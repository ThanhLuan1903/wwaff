/*-------------network----------------*/
$('.typenet').change(function(){
    chonpb();
})

$('.pbcolleft input').change(function(){
    var id =$(this).attr('title');
    var gt = $(this).val();
    if(gt!=''){
       if(id=='#pass'){ gt=gt+'/?';}
       if(id=='#0'){gt=gt+'=';}
       if(id=='#2'||id=='#4'){        
            gt='&'+gt+'=';
       } 
    }
    $(id).text(gt); 
    loaibohtml();
});
quyetinput();
chonpb();
function quyetinput(){
    $('.pbcolleft input').each(function(){
        var id =$(this).attr('title');
        var gt = $(this).val();
        if(gt!=''){
            if(id=='#pass'){ gt=gt+'/?';}
            if(id=='#0'){gt=gt+'=';}
            if(id=='#2'||id=='#4'){        
                gt='&'+gt+'=';
            }
            $(id).text(gt); 
            loaibohtml();
        }
        
    });
}
function chonpb(){
    var fun='banner';    
    $('.type_net').text(fun);
    loaibohtml();
}
function loaibohtml(){
    var lt='';
    $('.link_pb span').each(function(){
        var text =$(this).text();  
        lt=lt+text ;
    });  
    $('#linkpb').text(lt);
    $('#linkadd').val(lt);
}