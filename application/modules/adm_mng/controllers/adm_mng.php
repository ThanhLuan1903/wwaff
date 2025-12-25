<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'libraries/auth/auth_plugin.php';

/**
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 */
class Adm_mng extends CI_Controller
{
    private $page_load = '';
    private $databk = '';
    private $base_url_trang = '#';
    private $total_rows = 100;
    private $per_page = 20;
    private $uri_segment = 5;
    public $pub_config = '';
    public $users = '';
    private $base_key = '';
    private $auth;

    function __construct()
    {
        parent::__construct();
        $this->load_thuvien();
        $this->auth = new Auth_plugin();

        if (!$this->session->userdata('adlogedin') || !$this->session->userdata('aduserid')) {
            redirect('ad_user');
            $this->inic->sysm();
            exit();
        } else {
            $this->session->set_userdata('upanh', 1);
        }

        $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
        $this->managerid = $this->session->userdata('aduserid');
        $this->users = $this->Admin_model->get_one('cpalead_manager', array('id' => $this->session->userdata('aduserid')));

        if ($this->users->parrent > 0) {
            $url = $this->uri->segment(2);
            $url3 = $this->uri->segment(3);
            if (
                ($url == 'ajax' && ($url3 != 'ban_user'  && $url3 != 'show_num' && $url3 != 'requestoff')) ||
                ($url == 'showev' && ($url3 != 'tracklink' && $url3 != 'report'))

            ) {
                echo 'Error';
                exit();
            }
            if ($url == 'route') {

                if ($url3 == 'users' || $url3 == 'request') {
                    if ($url3 == 'users') redirect(base_url('manager/affiliate'));
                } else {
                    exit();
                }
            }
        }
    }

    function coppy_offer($id = 0)
    {
        $id = (int)$id;
        $o = $this->db->where('id', $id)->get('offer')->result_array();

        if ($o[0]['reqdev'] == '1') {
            $dev_set = $this->Home_model->get_one('dev_set', array("offer_id" => $o[0]['id']));
            unset($dev_set->created_at, $dev_set->updated_at, $dev_set->id);
        }

        if ($o[0]['reqlang'] == '1') {
            $off_lang = $this->Home_model->get_data('off_lang', array("offer_id" => $o[0]['id']));
            $off_ctry = $this->Home_model->get_data('off_ctry', array("offer_id" => $o[0]['id']));
            if ($off_lang) {
                foreach ($off_lang as $lang) {
                    unset($lang->id);
                }
            }
            if ($off_ctry) {
                foreach ($off_ctry as $ctry) {
                    unset($ctry->id);
                }
            }
        }

        if (!empty($o)) {
            $o = $o[0];
            unset($o['id']);
            $this->db->insert('offer', $o);

            $newid = $this->db->insert_id();

            if (!empty($dev_set)) {
                $dev_set->offer_id = $newid;
                $this->db->insert('dev_set', (array)$dev_set);
            }

            if (!empty($off_ctry)) {
                foreach ($off_ctry as $ctry) {
                    $ctry->offer_id = $newid;
                    $this->db->insert('off_ctry', (array)$ctry);
                }
            }

            if (!empty($off_lang)) {
                foreach ($off_lang as $lang) {
                    $lang->offer_id = $newid;
                    $this->db->insert('off_lang', (array)$lang);
                }
            }

            $this->session->set_userdata('messenger', 'complete copy offer!');
        } else {
            $this->session->set_userdata('messenger', 'Error!');
        }
        redirect($_SERVER["HTTP_REFERER"]);
    }

    function viewmember($role, $id = 0)
    {
        $this->session->set_userdata('logedin', 1);
        $this->session->set_userdata('userid', $id);

        if ($role === 'publisher') {
            $this->session->set_userdata('role', Auth_plugin::PUBLISHER_ROLE);
            $userFactory = $this->auth->user_factory(Auth_plugin::PUBLISHER_ROLE);
            $user = $userFactory->get_user($id);
            $this->session->set_userdata('user', $user);
        }

        if ($role === 'advertiser') {
            $this->session->set_userdata('role', Auth_plugin::ADVERTISER_ROLE);
            $userFactory = $this->auth->user_factory(Auth_plugin::ADVERTISER_ROLE);
            $user = $userFactory->get_user($id);
            $this->session->set_userdata('user', $user);
        }

        return redirect("v2");
    }

    function editpass($id = 0)
    {
        $tb = 'Lỗi';
        $pass1 = $this->input->post('pass');
        $pass = sha1(md5($pass1));
        if ($pass1) {
            $this->db->where('id', $id);
            $this->db->update('users', array('password' => $pass));
            $tb = "Đổi mật khẩu thành công!";
        } else {
            $tb = "Vui lòng nhập mật khẩu!";
        }
        $url = base_url() . $this->config->item('manager') . '/route/users/list/';
        echo '
        <style>body{text-align:center;padding-top:50px}</style>
        <meta http-equiv="refresh" content="3;url=' . $url . '" />
        <b>' . $tb . '</b> <br/>Trang web sẽ tự động chuyển sau 3s';
    }

    function ip()
    {
        echo $this->input->ip_address();
    }

    function affiliate($offset = 0)
    {
        $w = $this->session->userdata('aff_where');
        $lk = $this->session->userdata('like');
        $mm = '';
        if ($w) {
            foreach ($w as $key => $v) {
                if ($mm) $mm .=  " AND $key= $v";
                else $mm .=  " $key= $v";
            }
        }
        if ($lk) {
            if (is_numeric($lk)) {
                if ($mm) $mm .=  " AND cpalead_users.id= $lk ";
                else $mm .=  "  cpalead_users.id= $lk ";
            } else {
                if ($mm) $mm .= " AND cpalead_users.email LIKE '%$lk%' ";
                else $mm .= " cpalead_users.email LIKE '%$lk%' ";
            }
        }
        if ($mm) {
            $mm = " WHERE $mm ";
        }

        $qr = "
            SELECT cpalead_users.*
            FROM cpalead_users
            INNER JOIN cpalead_manager ON (cpalead_users.manager = cpalead_manager.id) AND (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)
            $mm
            ORDER BY cpalead_users.id DESC 
            LIMIT $offset,$this->per_page
        ";
        $dt = $this->db->query($qr)->result();

        $qr = "
            SELECT COUNT(*) as total
            FROM cpalead_users
            INNER JOIN cpalead_manager ON cpalead_users.manager = cpalead_manager.id AND (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)
            $mm
                      
        ";
        $this->uri_segment = 3;
        $this->total_rows = $this->db->query($qr)->row()->total;
        $this->base_url_trang = base_url($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/');
        $this->phantrang();
        if ($this->users->parrent > 0) {
            $pg = 'users_list_sub.php';
        } else {
            $pg = 'manager/content/users_list.php';
        }
        $sub =  $this->db->query(" SELECT id,username as title FROM cpalead_manager WHERE id = $this->managerid OR parrent = $this->managerid ")->result();

        $content = $this->load->view($pg, array('dulieu' => $dt, 'category' => $sub), true);
        $this->load->view('manager/index', array('content' => $content));
    }

    function offerRequest($offset = 0)
    {
        $qr = "
        SELECT cpalead_request.*, cpalead_offer.title as offer_title, cpalead_offer.offercat, cpalead_network.title as network_title
        FROM cpalead_request
        INNER JOIN cpalead_users ON cpalead_users.id = cpalead_request.userid
        INNER JOIN cpalead_manager ON (cpalead_users.manager = cpalead_manager.id) AND (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)
        LEFT JOIN cpalead_offer ON cpalead_offer.id = cpalead_request.offerid
        LEFT JOIN cpalead_network ON cpalead_network.id = cpalead_offer.idnet
        ORDER BY cpalead_request.id DESC
        LIMIT $offset,$this->per_page
    ";
        $dt = $this->db->query($qr)->result();

        $all_offercats = $this->Admin_model->get_data('offercat', array('show' => 1));

        foreach ($dt as $row) {
            if (!empty($row->offercat)) {
                $cat_ids = explode('o', trim($row->offercat, 'o'));
                $cat_ids = array_filter($cat_ids);

                if (!empty($cat_ids) && !empty($all_offercats)) {
                    $cat_titles = [];
                    foreach ($all_offercats as $offercat) {
                        if (in_array($offercat->id, $cat_ids)) {
                            $cat_titles[] = $offercat->offercat;
                        }
                    }
                    $row->category_titles = implode(', ', $cat_titles);
                } else {
                    $row->category_titles = '';
                }
            } else {
                $row->category_titles = '';
            }
        }

        $qr = "
            SELECT COUNT(*) as total
            FROM cpalead_request
            INNER JOIN cpalead_users ON cpalead_users.id = cpalead_request.userid
            INNER JOIN cpalead_manager ON cpalead_users.manager = cpalead_manager.id AND (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)
            
            $where            
        ";
        $this->uri_segment = 3;
        $this->total_rows = $this->db->query($qr)->row()->total;
        $this->base_url_trang = base_url($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/');
        $this->phantrang();
        if ($this->users->parrent > 0) {
            $pg = 'manager/content/request_list_sub.php';
        } else {
            $pg = 'manager/content/request_list.php';
        }


        $content = $this->load->view($pg, array('dulieu' => $dt), true);
        $this->load->view('manager/index', array('content' => $content));
    }

    function cashout()
    {
        $this->db->update('users_group', array('type' => 1));
        redirect('admin');
    }

    function ajaxsetting()
    {
        $data = $this->security->xss_clean($_POST);
        $data['reg_success_pub'] = 'You have successfully registered!. please active your email address.If you don\'t see the verification email in your inbox, please check your Junk or Spam folders.';
        $data['reg_success_adv'] = 'Thanks for your submission, we will contact you for further information.';
        $data['log_adv'] = 'Your submission has been completed, please allow 3-5 businesses days for processing. Thanks';
        $data['acc_pendding'] = 'your account is currently processing, please allow 3-5 business days to respond.';
        $data['acc_banned'] = 'your account has been suspended. Contact your affiliate manager for further informations';
        $data['acc_pause'] = 'your account has been paused. Contact your affiliate manager for further informations';
        $data['rate'] = $data['rate'] / 100;
        file_put_contents('setting_file/cip.txt', $data['checkip']);
        file_put_contents('setting_file/strictness.txt', $data['strictness']);
        unset($data['checkip']);
        unset($data['strictness']);
        file_put_contents('setting_file/publisher.txt', serialize($data));
    }

    function ajaxsmartlink()
    {
        $data = $this->security->xss_clean($_POST);
        file_put_contents('setting_file/smartlink.txt', serialize($data));
    }

    function index()
    {

        redirect(base_url('manager/happening'));
    }

    function happening($offset = 0)
    {
        $qr = "
         SELECT cpalead_tracklink.*, cpalead_users.email
         FROM cpalead_tracklink    
         INNER JOIN cpalead_users ON cpalead_tracklink.userid = cpalead_users.id    
         INNER JOIN cpalead_manager ON cpalead_users.manager = cpalead_manager.id AND (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)
         WHERE cpalead_tracklink.flead=1
         ORDER BY cpalead_tracklink.id DESC
         LIMIT $this->per_page OFFSET  $offset   
         
        ";
        $happening = $this->db->query($qr)->result();

        $qr = "
         SELECT count(cpalead_tracklink.id) as total
         FROM cpalead_tracklink
         INNER JOIN cpalead_users ON cpalead_tracklink.userid = cpalead_users.id        
         INNER JOIN cpalead_manager ON cpalead_users.manager = cpalead_manager.id AND (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)
         WHERE cpalead_tracklink.flead=1      
        ";
        $this->total_rows = $this->db->query($qr)->row()->total;
        $this->uri_segment = 3;
        $this->base_url_trang = base_url('manager/happening/');
        $this->phantrang();
        $content = $this->load->view('manager/content/tracklink_list.php', array('dulieu' => $happening), true);
        $this->load->view('manager/index', array('content' => $content));
    }

    function ajaxpayout()
    {
        $id = (int)$this->input->post('id', true);
        $val = (float)$this->input->post('val', true);
        $us = $this->Admin_model->get_one('users', array('id' => $id));
        if ($us->curent < $val) {
            $val = $us->curent;
        }

        $this->db->where('id', $id);
        $this->db->set('curent', "curent -$val", FALSE);
        $this->db->update('users');
        $this->db->insert('invoice', array('amount' => $val, 'usersid' => $id, 'note' => 'Pay', 'status' => 'Complete'));
        echo $us->curent - $val;
    }

    function ajaxdislead()
    {
        $id = (int)$this->input->post('id', true);
        $val = $this->input->post('val', true);
        $this->db->where('id', $id);
        $this->db->update('users', array('dislead' => $val));
    }

    function ajax()
    {
        $table = $this->uri->segment(4);
        $field = $this->uri->segment(5);
        $giatri = $this->uri->segment(6);
        if ($_POST) {
            $dt = $this->security->xss_clean($_POST);
            if (!empty($dt['data'])) {
                $data = $dt['data'];
            }
        } else $data = array();
        switch ($this->security->xss_clean($this->uri->segment(3))) {
            case 'unpub':
                if ($dt) {
                    $table = $this->session->userdata('table12');
                    $this->db->where('id', $dt['id']);
                    $this->db->update($table, array($dt['field'] => $dt['value']));
                    echo str_replace($dt['current'], "", $dt['change']);
                }
                break;

            case 'unpub2':
                $this->Admin_model->update(
                    $table,
                    array($field => $giatri),
                    array('id' => $data)
                );
                echo '#' . $field . $data;
                break;
            case 'action':
                if (!empty($data)) {
                    foreach ($data as $data) {
                        $id[] = $data['value'];
                        if ($table == 'credit' && $_POST['hanhdong'] == 'del') {
                            $this->db->where('id', $data['value']);
                            $dl = $this->db->get('credit')->row();
                            if ($dl) {
                                $this->db->where('id', $dl->iduser);
                                $this->db->set('curent', 'curent -' . $dl->point, FALSE);
                                $this->db->set('total', 'total -' . $dl->point, FALSE);
                                $this->db->update('users');
                            }
                        }
                    }
                    $this->db->where_in('id', $id);
                    if ($_POST['hanhdong'] == 'del') {
                        $this->db->delete($table);
                    } elseif ($_POST['hanhdong'] == 'disable') {
                        $this->db->update($table, array('show' => 0));
                    } elseif ($_POST['hanhdong'] == 'active') {
                        $this->db->update($table, array('show' => 1));
                    }
                }
                redirect($this->config->item('manager') . '/show_ajax/' . $table . '/list');
                break;
            case 'offercat':
                if (!empty($data)) {
                    $this->session->set_userdata('idin', $data);
                } else {
                    $this->session->unset_userdata('idin');
                }
                if (!empty($_POST['like'])) {
                    $this->session->set_userdata('like', $_POST['like']);
                } else {
                    $this->session->unset_userdata('like');
                }
                redirect($this->config->item('manager') . '/route/offer/list');
                break;
            case 'show_num':
                $limit = $this->session->userdata('limit');
                $limit['0'] = $data;
                $this->session->set_userdata('limit', $limit);
                break;
            case 'filter_cat':
                switch ($table) {
                    case 'content':
                        if ($data == 0) {
                            $this->session->set_userdata('where', array('show' => 1));
                        } else $this->session->set_userdata('where', array('catid' => $data, 'show' => 1));
                        redirect($this->config->item('manager') . '/show_ajax/' . $table . '/list');
                        break;
                    case 'offer':
                        if ($data == 0) {
                            $this->session->set_userdata('where', array('show' => 1));
                        } else $this->session->set_userdata('where', array('idnet' => $data));
                        redirect($this->config->item('manager') . '/show_ajax/' . $table . '/list');
                        break;
                    case 'users':
                        if ($data == 0) {
                            $this->session->set_userdata('where', array('id !=' => 1));
                        } else $this->session->set_userdata('where', array('manager' => $data, 'id !=' => 1));
                        redirect($this->config->item('manager') . '/show_ajax/' . $table . '/list');
                        break;
                    case 'payment':
                        if ($data == 0) {
                            $this->session->set_userdata('where', array('id !=' => 1));
                        } else $this->session->set_userdata('where', array('manager' => $data, 'id !=' => 1));
                        redirect($this->config->item('manager') . '/show_ajax/' . $table . '/list');
                        break;
                }
                break;
            case 'get_net':
                $dt = $this->Admin_model->get_one('network', array('id' => $data));
                $pbv_array = unserialize($dt->pb_value);
                echo base_url() . 'postback/off/' . $table . '/' . $dt->pb_pass . '?' . $pbv_array['subid'][0] . '=' . $pbv_array['subid'][1] . '&' . $pbv_array['commission'][0] . '=' . $pbv_array['commission'][1]; //'pass?userid=xxx';//$table chinh la id cua off dang add hoac edit  
                break;
            case 'order':
                $this->session->set_userdata('order', array($field, $table));
                break;

            case 'ban_user':
                if ($_POST) {
                    $id = (int)$this->input->post('id', true);
                    $val = (int)$this->input->post('val', true);

                    $this->db->where('id', $id);
                    $this->db->update('users', array('status' => $val));
                    $acc = $this->Admin_model->get_one('users', array('id' => $id));
                    $toemail = trim($acc->email);
                    $tieude = '';
                    $noidung = '';
                    $mailign = unserialize($acc->mailling);
                    $firstname = $mailign['firstname'];
                    $lastname = $mailign['lastname'];

                    if ($val == 0) {
                    }

                    if ($val == 1) {
                        $tieude = 'Your Application Has Been Approved';
                        $noidung = "
                            Dear Partner,<p>
                            We have reviewed your application and you have been approved as a Wedebeek affiliate. You may now log into obtain creatives to promote all of our offers. Your login information is as follows:
                                <br/>
                            Wedebeek Log in Link:<br/>
                            Log in link: https://wedebeek.com/v2/sign/in
                            <br/>
                            
                            Username:<br/>
                            $acc->email / Your password seting.<br/>

                            Postback Information:<br/>
                            Clickid: {sub1}<br/>
                            Pubid: {sub2}<br/>
                            Conversion payout: {sum}<br/>
                            You can check more marco in postback seting account.<br/>          
                            For help your account approval faster kindly contact your manager via email: " . $this->users->email . " or skype id: " . $this->users->skype . ".

                            You will be assigned a account manager in the next 48 hours, in which time they will be in contact to introduce themselves.<br/>

                            Many Thanks                 <br/>       
                            
                        ";
                        if (!$this->guimail($toemail, $tieude, $noidung)) {
                            $this->guimail($toemail, $tieude, $noidung);
                        }
                    }

                    if ($val == 2) {
                        $tieude = 'Welcome to ' . $this->pub_config['sitename'] . '- Account paused!';
                        $noidung = 'Dear partner!<p>
                        We\'re sorry to report that your account has been paused for quality coming from traffic source.<br/> 
                        Contact skype if you have any question: ' . $this->users->skype . '  ( ' . $this->users->name . '|Wedebeek ).';
                        if (!$this->guimail($toemail, $tieude, $noidung)) {
                            $this->guimail($toemail, $tieude, $noidung);
                        }
                    }

                    if ($val == 3) {
                        $tieude = 'Welcome to ' . $this->pub_config['sitename'] . '- Account banned!';
                        $noidung = 'Dear partner!<p>
                        We\'re sorry to report that your account has been banned for quality coming from traffic source.<br/> 
                        Contact skype if you have any question: ' . $this->users->skype . '  ( ' . $this->users->name . '|Wedebeek ).';
                        if (!$this->guimail($toemail, $tieude, $noidung)) {
                            $this->guimail($toemail, $tieude, $noidung);
                        }
                    }

                    if ($val == 4) {
                        $tieude = 'Account is not approved';
                        $noidung = 'Dear Partner,<p>
                        Thank you for showing your interest in cooperation with Wedebeek, we really appreciate it.<br/> 
                        Sorry, at the moment we can not accept you as an affiliate, but will place your request to our waiting list and will contact in case there is a possibility.
                        ';
                        if (!$this->guimail($toemail, $tieude, $noidung)) {
                            $this->guimail($toemail, $tieude, $noidung);
                        }
                    }

                    echo $val;
                }
                break;
            case 'manager':

                if ($_POST) {
                    $id = $this->input->post('id', true);
                    $val = $this->input->post('val', true);
                    $this->db->where('id', $id);
                    $this->db->update('users', array('manager' => $val));
                    echo $id;
                }
                break;
            case 'requestoff':
                if ($_POST) {
                    $id = $this->input->post('id', true);
                    $val = $this->input->post('val', true);
                    $this->db->where('id', $id);
                    $this->db->update('request', array('status' => $val));
                    echo $id;
                }
                break;
        }
    }

    private function guimail($toemail = '', $tieude = '', $noidung = '')
    {
        $domain = 'noreply3.wedebeek.com';
        $api = '738d80a2f18a41c0c4d6a9e67696516c-31eedc68-b5347e9d';
        $from = $this->pub_config['sitename'] . '<' . $this->session->userdata('ademail') . '>';
        $txt = strip_tags($noidung);
        $curl_post_data = array(
            'from'    => $from,
            'to'      => $toemail,
            'subject' => $tieude,
            'html' => $noidung,
            'text'    => $txt
        );

        $service_url = 'https://api.mailgun.net/v3/' . $domain . '/messages';
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "api:$api");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $curl_response = curl_exec($curl);
        $response = json_decode($curl_response);
        curl_close($curl);
        if ($response->message == 'Queued. Thank you.') return 1;
        else return 0;
    }

    function show_ajax($table, $dieukhien)
    {
        echo $this->run($table, $dieukhien);
    }

    function show_every($table, $dieukhien, $number)
    {
        echo $this->run($table, $dieukhien, $number);
    }

    function search($table)
    {
        if ($_POST) {
            $key = trim($this->input->post('keycode'));
            $balance = $this->input->post('balance');
            $pending = $this->input->post('pending');
            $current = $this->input->post('curent');
            if ($key) {
                $this->session->set_userdata('like', $key);
            } else {
                $this->session->unset_userdata('like');
            }

            $where = $this->session->userdata('aff_where');
            if ($balance) {
                $where['balance >'] = 1;
            } else {
                unset($where['balance >']);
            }
            if ($pending) {
                $where['pending >'] = 1;
            } else {
                unset($where['pending >']);
            }
            if ($current) {
                $where['curent >'] = 1;
            } else {
                unset($where['curent >']);
            }
            $this->session->set_userdata('aff_where', $where);
        }
    }

    function emailtool($offset = 0)
    {
        $this->per_page = 50;
        $enail_search = '';
        $dt = '';
        if ($_POST) {
            $tieude = $_POST['sub'];
            $noidung = $_POST['ct'];
            $uid = $_POST['uid'];
            $enail_search = trim($_POST['search']);
            $action = $_POST['act'];
            $wherein = $w = '';
            if ($action == 'send') {
                if (!empty($uid)) {
                    if ($tieude) $this->session->set_userdata('sub', $tieude);
                    if ($noidung) $this->session->set_userdata('ct', $noidung);
                    $this->db->select(array('email', 'mailling'));
                    $this->db->where_in('id', $uid);
                    $user = $this->Admin_model->get_data('users', array('id !=' => 1, 'manager' => $this->managerid));
                    $t = $e = 0;
                    if (!empty($user)) {
                        foreach ($user as $user) {
                            if ($this->guimail($user->email, $tieude, $noidung)) {
                                $t++;
                            } else {
                                $e++;
                                $err .= $user->email . '<br/>';
                            }
                        }
                    }
                }
                $dt = 'Success: ' . $t . ' <p>Error:<br/>' . $err;
            }
            if ($action == 'search') {

                if ($enail_search) {
                    $wherein = array_map('trim', explode("\n", str_replace("\r", "", $enail_search)));
                }
            }
        } else {
            $dt = '';
        }

        $emai_serch = '';
        if (!empty($wherein)) {
            $emai_serch = " AND cpalead_users.email in ('" . implode("','", $wherein) . "') ";
        }

        $qr = "
         SELECT cpalead_users.*, cpalead_manager.name
         FROM cpalead_users        
         INNER JOIN cpalead_manager ON cpalead_users.manager = cpalead_manager.id AND (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)
         WHERE cpalead_users.id !=1 AND cpalead_users.status=1 $emai_serch
         LIMIT $this->per_page OFFSET  $offset     
        ";
        $dtuser = $this->db->query($qr)->result();
        //
        //phan trang       
        $qr = "
         SELECT count(cpalead_users.id) as total
         FROM cpalead_users        
         INNER JOIN cpalead_manager ON cpalead_users.manager = cpalead_manager.id AND (cpalead_manager.id = $this->managerid OR cpalead_manager.parrent = $this->managerid)
         WHERE cpalead_users.id !=1 AND cpalead_users.status=1 $emai_serch        
        ";
        $this->total_rows = $this->db->query($qr)->row()->total;

        $this->uri_segment = 3;
        $this->base_url_trang = base_url('manager/emailtool/');
        $this->phantrang();
        //

        $content = $this->load->view('manager/content/emailtool.php', array('dt' => $dt, 'us' => $dtuser, 'enail_search' => $enail_search), true);
        $this->load->view('manager/index', array('content' => $content));
    }

    function userdooffer($id = 0)
    {
        $this->db->select('userid');
        $this->db->group_by('userid');
        $this->db->where('offerid', $id);
        $dt = $this->db->get('tracklink')->result();
        $m = array();
        if (!empty($dt)) {
            foreach ($dt as $dt) {
                $m[] = $dt->userid;
            }
        }
        $dt = array();
        if (!empty($m)) {
            $this->db->select(array('id', 'email', 'phone', 'curent'));
            $this->db->where_in('id', $m);
            $dt = $this->db->get('users')->result();
        }
        $this->load->view('manager/content/user_do_offer.php', array('dt' => $dt));
    }

    function show_user($id = 0)
    {
        echo $this->run('users', 'edit', $id);
    }

    function addusers()
    {
        $thongbao = '';
        if ($_POST) {
            $data['activated'] = 1;
            $data['status'] = 1;
            $data['ref'] = "manager_creater_" . $this->managerid;
            $data['manager'] =  $this->managerid;
            $data['balance'] = $data['curent'] = $_POST['balance'];

            $chuoimailing = 'a:15:{s:9:"firstname";s:3:"N/A";s:8:"lastname";s:3:"N/A";s:7:"company";s:3:"N/A";s:2:"ad";s:3:"N/A";s:4:"city";s:3:"N/A";s:5:"state";s:3:"N/A";s:3:"zip";s:3:"N/A";s:7:"country";s:13:"United States";s:3:"ssn";s:0:"";s:14:"payment_method";s:6:"Paypal";s:12:"payment_info";s:3:"N/A";s:10:"incentives";s:2:"NO";s:8:"Birthday";s:3:"N/A";s:11:"trafficdesc";s:3:"N/A";s:13:"affiliate_man";s:3:"N/A";}';
            $mailing = unserialize($chuoimailing);
            if ($_POST['firstname']) $mailing['firstname'] = $_POST['firstname'];
            else $mailing['firstname'] = 'N/A';
            if ($_POST['lastname']) $mailing['lastname'] = $_POST['lastname'];
            else $mailing['lastname'] = 'N/A';
            $data['mailling'] = serialize($mailing);
            $data['ip'] = 01111111;
            $data['ref'] = 0;

            if ($_POST['password'] &&  $_POST['email']) {
                $data['password'] = sha1(md5($_POST['password']));
                $data['email'] = $_POST['email'];

                if ($this->Home_model->get_one('users', array('email' => $_POST['email']))) {
                    $thongbao = 'Emails exits!!!';
                } else {
                    if ($this->db->insert('users', $data)) {
                        $thongbao = 'Done!!';
                    } else {
                        $thongbao = 'Error!!';
                    }
                }
            } else {
                $thongbao = 'Email or password not required!!';
            }
        }
        $dt = 1;
        $this->load->view(
            'manager/index',
            array(
                'content' => $this->load->view('manager/content/addusers', array('thongbao' => $thongbao), true)
            )
        );
    }

    function showev($table, $dieukhien = '', $number = '')
    {
        $this->load->helper('excel');
        if ($table == 'report') {
            if ($_POST) {
                if ($this->input->post('reset')) {
                    $this->session->unset_userdata('from');
                    $this->session->unset_userdata('to');
                    $this->session->unset_userdata('pubcheck');
                    $this->session->unset_userdata('pubid');
                    $this->session->unset_userdata('oid');
                    $this->session->unset_userdata('s2');
                    $this->session->unset_userdata('idnet');
                    $this->session->unset_userdata('status');
                    $this->session->unset_userdata('timezone_report');
                } else {
                    $from = $this->input->post('from', true);
                    $to = $this->input->post('to', true);
                    $this->session->set_userdata('from', $from);
                    $this->session->set_userdata('to', $to);
                    $this->session->set_userdata('pubcheck', $this->input->post('pubcheck', true));
                    $this->session->set_userdata('pubid', $this->input->post('pubid', true));
                    $this->session->set_userdata('oid', $this->input->post('oid', true));
                    $this->session->set_userdata('s2', $this->input->post('s2', true));
                    $this->session->set_userdata('idnet', $this->input->post('idnet', true));
                    $this->session->set_userdata('status', $this->input->post('status', true));
                    $this->session->set_userdata('timezone_report', $this->input->post('timezone_report', true));
                }
            }

            if (!$this->session->userdata('from')) {
                $from = date('Y-m-d', time());
                $this->session->set_userdata('from', $from);
            }
            if (!$this->session->userdata('to')) {
                $to = date('Y-m-d', time());
                $this->session->set_userdata('to', $to);
            }

            $from = $this->session->userdata('from');
            $to = $this->session->userdata('to');
            $timezone_report = $this->session->userdata('timezone_report'); // Lấy từ session

            if ($timezone_report == 1) {
                $from = $from . " 12:00:00";
                $to = date('Y-m-d', strtotime('+1 day', strtotime($to))) . " 11:59:59";
            } else {
                $from = $from . " 00:00:00";
                $to = $to . " 23:59:59";
            }

            $pubcheck = (int)$this->session->userdata('pubcheck');
            $pubid = (int)$this->session->userdata('pubid');
            $oid = (int)$this->session->userdata('oid');
            $s2 = (int)$this->session->userdata('s2');
            $idnet = (int)$this->session->userdata('idnet');
            $status = (int)$this->session->userdata('status');

            $where_conditions = array();

            if ($oid) {
                $where_conditions[] = 'cpalead_tracklink.offerid = ' . (int)$oid;
            }

            if ($s2) {
                $where_conditions[] = 'cpalead_tracklink.s2 = ' . (int)$s2;
            }

            if ($idnet) {
                $where_conditions[] = 'cpalead_tracklink.idnet = ' . (int)$idnet;
            }

            if ($status) {
                $where_conditions[] = 'cpalead_tracklink.status = ' . (int)$status;
            }

            if ($pubid) {
                $where_conditions[] = 'cpalead_tracklink.userid = ' . (int)$pubid;
            }

            $where = !empty($where_conditions) ? implode(' AND ', $where_conditions) . ' AND ' : '';

            $groupby = 'cpalead_tracklink.offerid';

            if ($s2) {
                $groupby .= ',cpalead_tracklink.s2';
            }

            if ($idnet) {
                $groupby .= ',cpalead_tracklink.idnet';
            }

            if ($status) {
                $groupby .= ',cpalead_tracklink.status';
            }

            if (!$pubid && $pubcheck) {
                $groupby .= ',cpalead_tracklink.userid';
            }

            $qr = "
                SELECT 
                    cpalead_tracklink.offerid,
                    cpalead_tracklink.s2,
                    cpalead_tracklink.idnet,
                    cpalead_tracklink.date,
                    cpalead_tracklink.userid,
                    cpalead_tracklink.oname,
                    COUNT(cpalead_tracklink.id) as click,
                    SUM(cpalead_tracklink.flead) as lead,
                    COUNT(DISTINCT cpalead_tracklink.ip) as uniq,
                    SUM(cpalead_tracklink.amount) as pay,
                    cpalead_users.email,
                    cpalead_manager.name,
                    cpalead_network.title,
                    CASE
                        WHEN cpalead_tracklink.status = 1 THEN 'Pending'
                        WHEN cpalead_tracklink.status = 2 THEN 'Declined'
                        WHEN cpalead_tracklink.status = 3 THEN 'Pay'
                        WHEN cpalead_tracklink.status = 4 THEN 'Approved'
                        ELSE 'Unknown'
                    END AS status
                FROM `cpalead_tracklink`
                INNER JOIN cpalead_users ON cpalead_tracklink.userid = cpalead_users.id
                INNER JOIN cpalead_manager ON cpalead_users.manager = cpalead_manager.id 
                    AND (cpalead_manager.id = ? OR cpalead_manager.parrent = ?)
                LEFT JOIN cpalead_network ON cpalead_network.id = cpalead_tracklink.idnet
                WHERE {$where} cpalead_tracklink.date BETWEEN ? AND ?
                GROUP BY {$groupby}
                ORDER BY cpalead_tracklink.id DESC";

            $rp = $this->db->query($qr, array(
                $this->managerid,
                $this->managerid,
                $from,
                $to
            ))->result();

            if ($this->session->userdata('timezone_report') == '1') {
                foreach ($rp as $item) {
                    $item->date = timestamp_to_gmt5($item->date, 'Y-m-d H:i:s');
                }
            }

            $ct = $this->load->view('manager/content/report.php', array('dulieu' => $rp), true);
            $this->load->view('manager/index', array('content' => $ct));
        }

        if ($table == 'groupcat') {
            $this->per_page = 100;
            $table = 'offercat';
            $this->page_load = 'groupcat_list';
            $this->load->view('manager/index', array('content' => $this->run($table, $dieukhien, $number)));
        }

        if ($table == 'tracklink') {
            $userid = (int)$dieukhien;
            $dieukhien = 'list';
            $qr = 'SELECT offerid, oname, COUNT(id) as click, SUM(flead) as lead, COUNT(DISTINCT ip) as uniq, SUM(amount) as pay 
               FROM `cpalead_tracklink` 
               WHERE userid = ? 
               GROUP BY offerid';
            $rp = $this->db->query($qr, array($userid))->result();
            $dt = $this->load->view('manager/content/user_credit', array('dulieu' => $rp), true);
            $this->load->view('manager/index', array('content' => $dt));
        }
    }

    function route($table, $dieukhien = '', $number = '')
    {
        if ($table == 'smartoffers' ||  $table == 'smartlinks') {
            $table = 'offer';
            $this->session->unset_userdata('osearch');
        }
        $this->load->view('manager/index', array('content' => $this->run($table, $dieukhien, $number)));
    }

    function run($table, $dieukhien, $number = '')
    {
        $limit1 =  $number;
        $smtype = $this->uri->segment(3);

        if (!$this->session->userdata('table12') || $table != $this->session->userdata('table12')) {
            $this->session->set_userdata('number', 0);
            $this->session->unset_userdata('order');
            $this->session->unset_userdata('where');
            $this->session->unset_userdata('like');
            $this->session->unset_userdata('limit');
            $this->session->set_userdata('table12', $table);
            $this->session->set_userdata('order', array('id', 'DESC'));
        }

        $limit =  $this->session->userdata('limit');

        if (empty($limit[0])) {
            $this->session->set_userdata('limit', array($this->per_page, '0'));
        }

        $limit =  $this->session->userdata('limit');
        $this->per_page = $limit[0];
        $data_view['category'] = $this->category($table, $number);

        if ($table == 'content' || $table == 'offer') {
            $data_view['mcategory'] = $this->mcat($this->category($table, $number));
        }

        if ($table == 'request') {
            $this->session->set_userdata('order', array('id', 'DESC'));
        }

        if ($this->db->table_exists($table)) {
            if (!empty($_POST)) {
                if ($this->validate($table)) {
                    $data = $this->xuly_data($table, $_POST);
                    $id = $this->input->post('id');

                    $dev_mode = isset($data['dev_mode']) ? $data['dev_mode'] : array();
                    $lang = isset($data['lang']) ? $data['lang'] : array();
                    $lang_off = isset($data['lang_off']) ? $data['lang_off'] : array();
                    $cr_mode = isset($data['cr_mode']) ? $data['cr_mode'] : array();

                    $keys_to_unset = ['dev_mode', 'lang', 'lang_off', 'cr_mode'];
                    foreach ($keys_to_unset as $key) {
                        unset($data[$key]);
                    }
                    if ($dev_mode) {
                        $dev_mode['offer_id'] = $id;
                    }

                    if (empty($id)) {
                        if ($table == 'request') {
                            $data['check_trung'] = $data['userid'] . '-' . $data['offerid'];
                            $check = $this->Admin_model->get_one($table, array('check_trung' => $data['check_trung']));
                            if ($check) {
                                goto khonginsert;
                            }
                        }

                        if ($table == 'offer') {
                            $adv = $this->Admin_model->get_one('network', array('id' => $data['idnet']));
                            $data['is_adv'] = $adv->adv_id;
                        }

                        $this->db->insert($table, $data);

                        $id = $this->db->insert_id();
                        if ($dev_mode) {
                            $dev_mode['offer_id'] = $id;
                            $this->db->insert('dev_set', $dev_mode);
                        }

                        if (!empty($lang)) {
                            $this->handleRequestData($id, $lang, 'off_ctry', 'country');
                            $this->handleRequestData($id, $lang_off, 'off_lang', 'lang_code');
                        }

                        // Thêm CR mode khi insert mới
                        if (!empty($cr_mode) && is_array($cr_mode)) {
                            $this->db->insert('cpalead_off_cr', [
                                'offer_id' => $id,
                                'cr_min' => (int)$cr_mode['cr_min'],
                                'cr_mode' => (int)$cr_mode['cr_mode'],
                                'min_conversions' => (int)$cr_mode['min_conversions']
                            ]);
                        }

                        if ($table == 'offer' && !empty($data['is_adv'])) {
                            redirect(base_url('manager/advertiser/list_products'));
                        }

                        khonginsert:
                        $data_view['success'] = 'Add !';
                    } elseif (is_numeric($id)) {
                        $check = $this->Admin_model->get_one($table, array('id' => $id));
                        if (!empty($check)) {
                            $this->Admin_model->update($table, $data, array('id' => $id));

                            if ($data['reqdev'] == 1) {
                                if (!empty($dev_mode)) {
                                    $this->deleteExistingData('dev_set', 'offer_id', $id);
                                    $this->db->insert('dev_set', $dev_mode);
                                }
                            } elseif ($data['reqdev'] == 0) {
                                $this->deleteExistingData('dev_set', 'offer_id', $id);
                                $this->deleteExistingData('device_counter', 'offer_id', $id);
                            }

                            if ($data['reqlang'] == 1) {
                                $this->handleRequestData($id, $lang_off, 'off_lang', 'lang_code');
                                $this->handleRequestData($id, $lang, 'off_ctry', 'country');
                            } elseif ($data['reqlang'] == 0) {
                                $this->deleteExistingData('off_lang', 'offer_id', $id);
                                $this->deleteExistingData('off_ctry', 'offer_id', $id);
                            }

                            // Thêm xử lý CR mode khi update
                            if ($data['reqcr'] == 1) {
                                $this->deleteExistingData('off_cr', 'offer_id', $id);
                                if (!empty($cr_mode) && is_array($cr_mode)) {
                                    $this->db->insert('cpalead_off_cr', [
                                        'offer_id' => $id,
                                        'cr_min' => (int)$cr_mode['cr_min'],
                                        'cr_mode' => (int)$cr_mode['cr_mode'],
                                        'min_conversions' => (int)$cr_mode['min_conversions']
                                    ]);
                                }
                            } elseif ($data['reqcr'] == 0) {
                                $this->deleteExistingData('off_cr', 'offer_id', $id);
                            }

                            $data_view['success'] = 'Editted!';
                        } else $data_view['error'] = 'id empty !!!';
                    } else $data_view['error'] = 'id empty ';

                    if ($table == 'slideshow') {
                        $this->slideshow();
                    }

                    $dieukhien = 'list';
                    $number = $this->session->userdata('number');
                } else  $dieukhien = 'edit';
                if ($table == 'disoffer' && $this->managerid > 1) {
                    redirect(base_url($this->config->item('manager') . '/disoffer/disoffer'));
                }
            }

            switch ($dieukhien) {
                case 'list':
                    $limit['1'] = $limit1;
                    $this->session->set_userdata('limit', $limit);
                    $this->session->set_userdata('number', $number);

                    if ($table == 'users') {
                        $where = $this->session->userdata('where');
                        $where['id !='] = 1;
                        $this->session->set_userdata('where', $where);
                    }

                    if ($table == 'offer' && $smtype == 'smartoffers') {
                        redirect(base_url($this->config->item('manager') . '/offers/smartoffers'));
                    }

                    if ($table == 'banners') {
                        redirect(base_url($this->config->item('manager') . '/custom/publisher_banners'));
                    }

                    if ($table == 'offer' && $smtype == 'smartlinks') {
                        redirect(base_url($this->config->item('manager') . '/offers/smartlinks'));
                    }

                    if ($table == 'offer') {
                        redirect(base_url($this->config->item('manager') . '/offers/listoffer'));
                    }

                    if ($table == 'tracklink') {
                        $vv = $this->session->userdata('where');
                        $vv['flead'] = 1;
                        $this->session->set_userdata('where', $vv);
                    }

                    if ($table == 'offer' && $this->session->userdata('idin')) {
                        foreach ($this->session->userdata('idin') as $ocat) {
                            $this->db->like('offercat', 'o' . $this->session->userdata('idin') . 'o');
                        }
                    }

                    if ($table == 'users') {
                        if ($this->session->userdata('like')) {
                            if (is_numeric($this->session->userdata('like'))) {
                                $this->db->like('id', $this->session->userdata('like'), 'none');
                            } else {
                                $this->db->like('email', $this->session->userdata('like'));
                            }
                        }
                        $where = $this->session->userdata('where');
                        $where['manager'] = $this->managerid;
                        $this->session->set_userdata('where', $where);
                    }

                    if ($table == 'offer') {
                        if ($this->session->userdata('like')) {
                            if (is_numeric($this->session->userdata('like'))) {
                                $this->db->like('id', $this->session->userdata('like'));
                            } else {
                                $this->db->like('title', $this->session->userdata('like'));
                            }
                        }
                    }

                    if ($table == 'manager') {
                        $where['parrent'] = $this->managerid;
                        $this->session->set_userdata('where', $where);
                    }

                    if ($table == 'tracklink') {
                        $vv = $this->session->userdata('where');
                        $vv['flead'] = 1;
                        $this->session->set_userdata('where', $vv);
                    }

                    $data_view['dulieu'] = $this->Admin_model->get_data(
                        $table,
                        $this->session->userdata('where'),
                        $this->session->userdata('order'),
                        $this->session->userdata('limit'),
                        $this->session->userdata('select')
                    );

                    if (empty($this->page_load)) {
                        $page = $table . '_list';
                    } else {
                        $page = $this->page_load;
                    }

                    $this->total_rows = $this->Admin_model->get_number($table, $this->session->userdata('where'));
                    $this->phantrang();
                    break;

                case 'edit':
                    $data_view['dulieu'] = $this->Admin_model->get_one($table, array('id' => $number));
                    $data_view['selectedctry'] = $this->Admin_model->get_data('off_ctry', array('offer_id' => $data_view['dulieu']->id));
                    $data_view['lang'] = $this->Admin_model->get_data('ctry_lang');
                    if ($table == 'offer') {
                        $dev_set = $this->Admin_model->get_one('dev_set', array('offer_id' => $number));
                        if ($dev_set !== false && $dev_set !== null) {
                            $data_view['dev_mode'] = $dev_set;
                        }

                        $cr_data = $this->Admin_model->get_one('off_cr', array('offer_id' => $data_view['dulieu']->id));
                        $data_view['cr_mode'] = $cr_data ? $cr_data->cr_min . '-' . $cr_data->cr_mode . '-' . $cr_data->min_conversions : null;

                        if ($smtype == 'smartoffers') {
                            $page = 'smartoff_edit';
                        } elseif ($smtype == 'smartlinks') {
                            $page = 'smartlink_edit';
                        } else {
                            $page = $table . '_edit';
                        }
                    } else {
                        $page = $table . '_edit';
                    }
                    break;
                case 'delete':
                    if ($table == 'credit') {
                        $this->db->where('id', $number);
                        $dl = $this->db->get('credit')->row();
                        if ($dl) {
                            $this->db->where('id', $dl->iduser);
                            $this->db->set('curent', 'curent -' . $dl->point, FALSE);
                            $this->db->set('total', 'total -' . $dl->point, FALSE);
                            $this->db->update('users');
                        }
                    }

                    $this->Admin_model->xoa($table, array('id' => $number));
                    $this->mensenger = 'da xoa xong';

                    if ($table == 'offer' && $smtype == 'smartoffers') {
                        redirect(base_url($this->config->item('manager') . '/offers/smartoffers'));
                    }

                    if ($table == 'offer' && $smtype == 'smartlinks') {
                        redirect(base_url($this->config->item('manager') . '/offers/smartlinks'));
                    }

                    if ($table == 'advertiser') {

                        redirect(base_url($this->config->item('manager') . '/advertiser/list_account'));
                    }

                    if ($table == 'offer') {
                        redirect(base_url($this->config->item('manager') . '/offers/listoffer'));
                    } else {
                        redirect($this->config->item('manager') . "/route/$table/list", 'refresh');
                    }

                    break;
                case 'add':
                    if ($table == 'network') {
                        $data_view['idnet'] = $this->Admin_model->select_max($table, 'id') + 1;
                    }
                    if ($table == 'offer') {
                        $data_view['lang'] = $this->Admin_model->get_data('ctry_lang');
                        if ($smtype == 'smartoffers') {
                            $page = 'smartoff_edit';
                        } elseif ($smtype == 'smartlinks') {
                            $page = 'smartlink_edit';
                        } else {
                            $page = $table . '_edit';
                        }
                    } else {
                        $page = $table . '_edit';
                    }
                    $data_view['dulieu'] = '';
                    break;
            }


            return $this->load->view('manager/content/' . $page, $data_view, true);
        }
    }

    function xuly_data($table, $data, $id = '')
    {
        if (!empty($table) && !empty($data)) {
            if (!empty($data['id'])) {
                unset($data['id']);
            }

            if ($table == 'network') {
                $data['pb_value'] = serialize($data['pb_value']);
            }

            if ($table == 'offer') {
                $smtype  = $this->uri->segment(3);
                $data['point_geos'] = serialize($data['point_geos']);
                $data['percent_geos'] = serialize($data['percent_geos']);
                $data['preview'] = serialize($data['preview']);
                $data['landingpage'] = serialize($data['landingpage']);
                $data['traffic_source'] = join(',', $data['traffic_source']);
                $data['restriced_traffics'] = join(',', $data['restriced_traffics']);

                if (!empty($data['country'])) {
                    $data['country'] = 'o' . implode('o', $data['country']) . 'o';
                } else {
                    $data['country'] = 'o';
                }

                if (!empty($data['offercat'])) {
                    $data['offercat'] = array_unique($data['offercat']);
                    $data['offercat'] = 'o' . implode('o', $data['offercat']) . 'o';
                } else {
                    $data['offercat'] = 'o';
                }

                if ($smtype == 'offer') {
                    @$netdt = $this->Admin_model->get_one('network', array('id' => $data['idnet']));
                    $pbv_array = unserialize($netdt->pb_value);
                    unset($pbv_array['4']);
                    unset($pbv_array['5']);
                    $data['subid'] = $netdt->subid;
                    $data['point'] = trim($data['point']);

                    if (empty($data['percent'])) {
                        $data['percent'] = 0;
                    }
                }

                if ($data['reqdev'] == 1) {
                    $data['dev_mode'] = [
                        'mode' => $data['mode'],
                        'desk_pct' => $data[$data['mode']]['desk_pct'],
                        'mob_pct' =>  $data[$data['mode']]['mob_pct']
                    ];
                    unset($data[$data['mode']]);
                    unset($data['mode']);
                }

                if (isset($data['lang'])) {
                    $this->db->select('lang');
                    $this->db->where_in('name', $data['lang']);
                    $data['lang_off'] = array_column($this->db->get('ctry_lang')->result_array(), 'lang');

                    $uniqueLanguages = [];

                    foreach ($data['lang_off'] as $langStr) {
                        $languages = explode(',', $langStr);

                        foreach ($languages as $lang) {
                            $lang = trim($lang);
                            if ($lang !== '') {
                                $uniqueLanguages[$lang] = true;
                            }
                        }
                    }

                    $data['lang_off'] = array_keys($uniqueLanguages);
                }

                // Thêm xử lý CR mode
                if (isset($data['cr_mode'])) {
                    $crModeValue = $data['cr_mode'];
                    list($crMin, $crMax, $minConversions) = explode('-', $crModeValue);

                    $data['cr_mode'] = [
                        'cr_min' => (int)$crMin,
                        'cr_mode' => (int)$crMax,
                        'min_conversions' => (int)$minConversions
                    ];
                }
            }
            
            if ($table == 'users_group') {
                if (!empty($data['password'])) {
                    $data['password'] = sha1(md5($data['password']));
                }
            }
            if ($table == 'manager') {
                if (!empty($data['password'])) {
                    $data['password'] = sha1(md5($data['password']));
                } else {
                    unset($data['password']);
                }
                $data['parrent'] = $this->managerid;
            }

            if ($table == 'disoffer') {

                $this->db->select('title');
                $o = $this->Admin_model->get_one('offer', array('id' => $data['offerid']));
                $data['offername'] = $o->title;
                $this->db->select('email');
                if ($this->managerid > 1) {
                    $wmnager = array('id' => $data['usersid'], 'manager' => $this->managerid);
                } else {
                    $wmnager = array('id' => $data['usersid']);
                }
                $u = $this->Admin_model->get_one('users', $wmnager);
                $data['email'] = $u->email;
            }
            return $data;
        }
    }

    private function handleRequestData($offer_id, $values, $table, $foreign_key_field)
    {
        $this->deleteExistingData($table, 'offer_id', $offer_id);

        if (!empty($values)) {
            foreach ($values as $value) {
                $insert_data = array(
                    'offer_id' => $offer_id,
                    $foreign_key_field => $value,
                );
                $this->db->insert($table, $insert_data);
            }
        }
    }

    private function deleteExistingData($table, $field, $value)
    {
        $existing = $this->db->get_where($table, array($field => $value))->num_rows();
        if ($existing > 0) {
            $this->Admin_model->xoa($table, array($field => $value));
        }
        return $existing > 0;
    }

    function getweek($ok = '')
    {
        $week = date("W", time());
        $ww = file_get_contents('week');
        if ($ok == 'ok') {
            file_put_contents('week', $week);
        }
        if ($week != $ww) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function category($table, $number = '')
    {
        switch ($table) {
            case 'payment':
                return $this->Admin_model->get_data('manager');
                break;
            case 'content':
                return $this->Admin_model->get_data('categories');
                break;
            case 'offer':
                return $this->Admin_model->get_data('network', array());
                break;
            case 'users':
                return $this->db->query("
                SELECT id,username as title FROM cpalead_manager WHERE id = $this->managerid OR parrent = $this->managerid
                ")->result();
                break;
            default:
                return true;
                break;
        }
    }

    function validate($table)
    {
        switch ($table) {
            case 'slideshow':
                $this->form_validation->set_rules('img', 'Images', 'required|xss_clean');
                $this->form_validation->set_rules('show', 'Show', 'required|xss_clean|numeric|min_length[1]|max_length[2]');
                break;
            case 'article':
                $this->form_validation->set_rules('title', 'Tên danh mục', 'required|xss_clean|min_length[2]');
                $this->form_validation->set_rules('noibat', 'nổi bật', 'numeric');
                break;
            case 'article_category':
                $this->form_validation->set_rules('title', 'Tên danh mục', 'required|xss_clean|min_length[2]');
                $this->form_validation->set_rules('publish', 'Hiển thị', 'required|numeric');
                break;
            default:
                return true;
        }
        if ($this->form_validation->run() == true) {
            return true;
        } else return false;
    }

    function load_thuvien()
    {
        $this->load->helper(array('alias_helper', 'text', 'form', 'timezone'));
        $this->load->model("Admin_model");
        $this->load->model('Custom_model');
    }

    function logout()
    {
        $this->session->unset_userdata('admin');
        $this->session->unset_userdata('adlogedin');
        $this->session->unset_userdata('aduserid');
        redirect(base_url($this->config->item('manager')));
    }

    function phantrang()
    {
        $this->load->library('pagination');
        if ($this->base_url_trang == '#') {
            $config['base_url'] = base_url() . $this->config->item('manager') . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/';
        } else {
            $config['base_url'] = $this->base_url_trang;
        }

        $config['total_rows'] = $this->total_rows;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = $this->uri_segment;
        $config['num_links'] = 7;
        $config['first_link'] = '<<';
        $config['first_tag_open'] = '<li class="firt_page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = '>>';
        $config['last_tag_open'] = '<li class="last_page">';
        $config['last_tag_close'] = '</li>';
        //-------next-
        $config['next_link'] = 'next &gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        //------------preview
        $config['prev_link'] = '&lt; prev';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        // ------------------cu?npage
        $config['cur_tag_open'] = '<li class="active"><a href=#>';
        $config['cur_tag_close'] = '</a></li>';
        //--so 
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        //-----
        $this->pagination->initialize($config);
    }

    function mcat($cat)
    {
        foreach ($cat as $cat) {
            $mcat[$cat->id] = $cat;
        }
        return $mcat;
    }

    function setupnet()
    {
        $this->load->view('manager/index', array('content' => $this->load->view('manager/setupnet', '', true)));
    }

    function test() {}

    function approvedall()
    {
        $this->db->where('status', 0);
        $u = $this->db->get('users')->result();
        foreach ($u as $u) {

            $this->db->where('id', $u->id);
            $this->db->update('users', array('status' => 1));

            $mailign = unserialize($u->mailling);
            $firstname = $mailign['firstname'];
            $lastname = $mailign['lastname'];
            $tieude = 'Welcome to ' . $this->pub_config['sitename'] . '- Approved';
            $noidung = "
                Dear <b>$firstname $lastname</b>,<p>
                Congratulation, your application has been approved.<br/>
                 In the meantime, please take a look at our current offers which listed in the offer page. If you have any other request then contact your affiliate manager for further information. 
                <br/>
                We are looking forward to lead you to the success in Affiliate Marketing.
                <br/>
                Contact skype if you have any question: " . $this->users->skype . "  ( " . $this->users->name . "|Wedebeek ).
                <p>
                Regards,<br/>
                Affiliate Application Team                            
                
            ";

            if (!$this->guimail($toemail, $tieude, $noidung)) {
                sleep(2);
                $this->guimail($toemail, $tieude, $noidung);
            }
        }
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */