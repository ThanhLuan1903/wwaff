/*----------------CKEDITOR------------------------
-------------------------------------------------*/
if ( typeof CKEDITOR == 'undefined' )
{
    document.write("khong ") ;
}
else
{
    if (document.getElementById("soanthao")) {
        var editor = CKEDITOR.replace( 'soanthao' );            
        CKFinder.setupCKEditor( editor, base_url+'ckeditor/ckfinder/' ) ; 
    }
    if (document.getElementById("soanthao1")) {
        var editor1 = CKEDITOR.replace( 'soanthao1' );            
        CKFinder.setupCKEditor( editor1, base_url+'ckeditor/ckfinder/' ) ;  
    }
              	
}
/*---NUT UPLOAD CKE-RIENT K CAN THI VAN UP O PHAN VIET BAI DC---------
--------------------------------------------------------------------*/
function BrowseServer(){
var finder = new CKFinder();
finder.basePath = '../';	// The path for the installation of CKFinder (default = "/ckfinder/").
finder.selectActionFunction = SetFileField;
finder.popup();                    	
}
function SetFileField( fileUrl )
{
document.getElementById( 'xFilePath' ).value = fileUrl;
}
                                
	