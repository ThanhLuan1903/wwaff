<?php             
    foreach($tableData as $dt){
        echo '
            <tr>                                               
                <td>
                    <input value="'.$dt.'" name="pb_value['.$dt.'][]" class="form-control form-control-sm" type="text" readonly/>
                </td>
                <td>
                    <input name="pb_value['.$dt.'][]" class="form-control form-control-sm" type="text" placeholder="Ex: {'.$dt.'}"/>
                </td>
            </tr>
            ';                                            
        
    }
?>