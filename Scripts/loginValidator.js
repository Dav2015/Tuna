/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var filter;
//filtro para o email podemos testar uma string com este regex
filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,3})$/;
//filter = /^([a-z0-9_\.\-])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,4})$/i;


// Validate the login form
function FormLoginValidator(theForm) {
  // Check to see if name isn't blank
  if ( theForm.password.value === "" ) {
    alert("Forget yourt password");
    theForm.name.focus();
    return false;
  }
  
  if ( !filter.test( theForm.email.value ) ) {
    alert('Please provide a valid e-mail address');
    theForm.email.focus();
    return false;
  }
  return true;
}