<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
class Postbacks extends CI_Controller
{

    private $per_page = 30;
    public $total_rows = 6;
    public $pub_config = '';
    /** @var object $member */
    public $member = '';
    public $member_info = '';
    public $is_adv = 0;

    function  __construct()
    {
        parent::__construct();
        $this->load->model('Offer_model');
        $this->load->model('Custom_model');
        $this->load->model('Partner_model');
        $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
        if ($this->session->userdata('role') == 1) {
            $table = 'users';
        } else if ($this->session->userdata('role') == 2) {
            $table = 'advertiser';
            $this->is_adv = 1;
        }
        if ($this->session->userdata('userid')) {
            $this->db->select($table . '.*,cpalead_api_key.api_key');
            $this->db->from($table);
            $this->db->join('api_key', 'api_key.user_id =' . $table . '.id AND cpalead_api_key.is_adv = ' . $this->is_adv, 'left');
            $this->db->where(array($table . '.id' => $this->session->userdata('userid')));
            $this->member = $this->db->get()->row();
            $this->member_info = isset($this->member->mailling) ? unserialize($this->member->mailling) : [];
        } else {
            redirect('v2/sign/in');
        }
    }

    function index()
    {
        echo '<h2>404 Page Not Found</h2> <br/> The page you requested was not found.';
    }

    public function postbackLog()
    {
        $data = [];
        $content = $this->load->view('postback/postbackLog.php', $data, true);
        $this->load->view('default/vindex.php', array('content' => $content));
    }

    public function postback()
    {
        $this->load->library('form_validation');
        if ($this->session->userdata('role') == 1) {
            return $this->pubPostback();
        } else if ($this->session->userdata('role') == 2) {
            return $this->advPostback();
        }
    }

    private function removeCurlyBraces($inputString)
    {
        $arrStringRemove = ['{', '}', '`', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '-', '+', '=', '[', ']'];
        foreach ($arrStringRemove as $dt) {
            $outputString = str_replace($arrStringRemove, '', $inputString);
        }
        return $outputString;
    }

    private function geneRatorSubString($data)
    {
        $subValue = $data['pb_value']['pub_id'][1] ? '&' . $this->removeCurlyBraces($data['pb_value']['pub_id'][1]) . '=#pubid#' : '';
        $subValue .= $data['pb_value']['clickid'][1] ? '&' . $this->removeCurlyBraces($data['pb_value']['clickid'][1]) . '=' : '';
        return $subValue;
    }

    function advAddPostback()
    {
        $data = $this->input->post() ?: [];
        header('Content-type: application/json');
        $this->load->helper('string');
        $randomString = random_string('alnum', 9);
        $subValue = $this->geneRatorSubString($data);
        if ($data['title']) {
            $id = (int)$data['pb_id'];
            $inserData = [
                'pb_pass' => $randomString,
                'adv_id' => $this->member->id,
                'title' => $data['title'],
                'pb_value' => serialize($data['pb_value']),
                'show' => 1,
                'order' => 0,
                'subid' => $subValue
            ];
            $queryString = $this->generatorUrl(serialize($data['pb_value']));
            if ($id) {
                unset($inserData['pb_pass']);
                $pbUrl = base_url("/advpostback/banner/{$id}/{$randomString}?{$queryString}");
                $inserData['linkadd'] = $pbUrl;
                $this->db->where(['adv_id' => $this->member->id, 'id' => $id])->update('network', $inserData);
                $mess =  [
                    'status' => 'success',
                    'messenger' => 'Update Postback Successfull'
                ];
            } else {
                $this->db->insert('network', $inserData);
                $insert_id = $this->db->insert_id();
                $pbUrl = base_url("/advpostback/banner/{$insert_id}/{$randomString}?{$queryString}");
                $this->db->where('id', $insert_id)->update('network', ['linkadd' => $pbUrl]);
                $mess =  [
                    'status' => 'success',
                    'messenger' => 'Add Postback Successfull'
                ];
            }
            echo json_encode($mess);
        } else {
            echo json_encode([
                'status' => 'error',
                'messenger' => 'Please enter network title'
            ]);
        }
    }

    function advDelPostback()
    {
        $postbackId = (int)$this->input->post('postback_id');
        $adv_id = $this->member->id;
        $check = $this->db->where(['idnet' => $postbackId, 'is_adv' => $adv_id])->get('offer')->num_rows();
        header('Content-type: application/json');
        if (!$check) {
            $this->db->where([
                'adv_id' => $adv_id,
                'id' => $postbackId
            ])->delete('network');
            echo json_encode([
                'status' => 'success',
                'messenger' => 'Remove Postback Successfull'
            ]);
        } else {
            echo json_encode([
                'status' => 'success',
                'messenger' => 'Cannot delete network because it has existing offers.'
            ]);
        }
    }

    function generatorUrl($data)
    {
        $tempArray = [];
        $arr = ['clickid', 'commission', 'sale_amount', 'pub_id'];
        if ($data) {
            $data = unserialize($data);
            foreach ($arr as $key) {
                $tempArray[] = ($data[$key][0] . "=" . $data[$key][1]);
            }
        }
        return implode('&', $tempArray);
    }

    function getListAdvPostback()
    {
        $postBack = $this->Home_model->get_data('network', array('adv_id' => $this->session->userdata('userid')));
        header('Content-type: application/json');
        $data = [];
        $option = '';
        $listPb = [];
        if ($postBack) {
            foreach ($postBack as $postBack) {
                $listPb[$postBack->id] = unserialize($postBack->pb_value);
                $listPb[$postBack->id]['name'] = $postBack->title;
                $queryString = $this->generatorUrl($postBack->pb_value);
                $option .= '<option value="' . $postBack->id . '">' . $postBack->title . '</option>';
                $data[] = '
                    <tr>
                        <th scope="row">' . $postBack->id . '</th>
                        <td>' . $postBack->title . '</td>
                        <td>' . base_url('advpostback/banner/' . $postBack->id . '/' . $postBack->pb_pass . '?' . $queryString) . '</td>
                        <td class="col text-end"  data-title="' . $postBack->title . '" data-postback_id = "' . $postBack->id . '" data-item="' . $queryString . '">
                            <input type="hidden" value="' . $postBack->pb_value . '">
                            <button  type="button" data-action="edit"  class="btn btn-sm btn-primary">
                                <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                            </button>
                            <button type="button" data-action="delete" class="btn btn-danger btn-sm">
                               <i class="fa fa-trash" aria-hidden="true"></i>
                                Remove
                            </button>
                        </td>
                    </tr>
                    ';
            }
        }
        echo json_encode(['tableList' => $data, 'selectbox' => $option, 'listPostback' => $listPb]);
    }

    function advPostback()
    {
        if ($_POST) {
            $this->form_validation->set_rules('postback', 'Postback URL', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $url = $this->input->post('postback');
                if ($this->Home_model->get_one('postback', array('affid' => $this->member->id))) {
                    $this->db->where(['affid' => $this->member->id])->update('postback', array('postback' => $url, 'enable' => 1, 'ip' => $this->input->ip_address()));
                } else {
                    $this->db->insert('postback', array('affid' => $this->member->id, 'postback' => $url, 'enable' => 1, 'ip' => $this->input->ip_address()));
                }
                $this->session->set_flashdata('success', 'successfully');
            } else {
            }
        }
        $data['postback_logs'] = $this->generatorPostbackLog($this->member->id);
        $data['postBack'] = $this->Home_model->get_data('postback', array('affid' => $this->member->id));
        $data['userData'] = $this->member;
        $content = $this->load->view('postback/adv_postback.php', $data, true);
        $this->load->view('default/vindex.php', array('content' => $content));
    }

    private function generatorPostbackLog($advId)
    {
        $pblog = [];
        $this->db->where('userids', $advId);
        $this->db->limit(10);
        $dt =  $this->db->get('adv_postback_log')->result();
        if ($dt) {
            foreach ($dt as $data) {
                $date = date('y-m-d', strtotime($data->time));
                $pblog[$date][] = array(
                    'subid' => $data->tracklink,
                    'campaignid' => $data->campaignid,
                    'finalurl' => $data->finalurl,
                    'response' => strip_tags($data->response),
                    'date' => $data->time
                );
            }
        }
        return $pblog;
    }

    function pubPostback()
    {
        if ($_POST) {
            $this->form_validation->set_rules('postback', 'Postback URL', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $url = $this->input->post('postback');
                if ($this->Home_model->get_one('postback', array('affid' => $this->member->id))) {
                    $this->db->where(['affid' => $this->member->id])->update('postback', array('postback' => $url, 'enable' => 1, 'ip' => $this->input->ip_address()));
                } else {
                    $this->db->insert('postback', array('affid' => $this->member->id, 'postback' => $url, 'enable' => 1, 'ip' => $this->input->ip_address()));
                }
                $this->session->set_flashdata('success', 'successfully');
            } else {
            }
        }

        $data['postBack'] = $this->Home_model->get_data('postback', array('affid' => $this->member->id));
        $data['userData'] = $this->member;
        $content = $this->load->view('postback/postback.php', $data, true);
        $this->load->view('default/vindex.php', array('content' => $content));
    }


    function ajax_test_postback()
    {

        if ($_POST) {
            $url = $this->input->post('url');
            if (strpos($url, '{sum}')) {
                //
                $url = str_replace('{sum}', $this->input->post('payout'), $url);
            } else {
                $url .= '&payout=' . $this->input->post('payout');
            }
            if (strpos($url, '{offerid}')) {
                //
                $url = str_replace('{offerid}', $this->input->post('offerid'), $url);
            } else {
                $url .= '&offerid=' . $this->input->post('v');
            }
            if (strpos($url, '{sub1}')) {
                //
                $url = str_replace('{sub1}', $this->input->post('sub1'), $url);
            } else {
                $url .= '&sub1=' . $this->input->post('sub1');
            }


            $result = $this->curl_senpost($url);
            echo json_encode(array('url' => $url, 'result' => $result));
        }
    }

    function curl_senpost($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);  
        curl_close($ch);
        return $result;
    }
}