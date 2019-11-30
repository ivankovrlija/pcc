// Set up GrapesJS editor with the Newsletter plugin
var editor = grapesjs.init({
  // noticeOnUnload: 0,
  blockManager: {
    autoload: 0,
  },
  container: '#gjs',
  fromElement: true,

  // plugins: ['gjs-plugin-forms'],
  // pluginsOpts: {
  //     'grapesjs-plugin-forms': {}
  // }
});

var blockManager = editor.BlockManager;

blockManager.add('form', {
  label: '<div><svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path class="gjs-block-svg-path" d="M22,5.5 C22,5.2 21.5,5 20.75,5 L3.25,5 C2.5,5 2,5.2 2,5.5 L2,8.5 C2,8.8 2.5,9 3.25,9 L20.75,9 C21.5,9 22,8.8 22,8.5 L22,5.5 Z M21,8 L3,8 L3,6 L21,6 L21,8 Z" fill-rule="nonzero"></path><path class="gjs-block-svg-path" d="M22,10.5 C22,10.2 21.5,10 20.75,10 L3.25,10 C2.5,10 2,10.2 2,10.5 L2,13.5 C2,13.8 2.5,14 3.25,14 L20.75,14 C21.5,14 22,13.8 22,13.5 L22,10.5 Z M21,13 L3,13 L3,11 L21,11 L21,13 Z" fill-rule="nonzero"></path><rect class="gjs-block-svg-path" x="2" y="15" width="10" height="3" rx="0.5"></rect></svg><p> Form</p></div>',
  content: '<form name="gq_form" style="min-height:150px;"></form>',
});

blockManager.add('button', {
  label: '<div><svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path class="gjs-block-svg-path" d="M22,9 C22,8.4 21.5,8 20.75,8 L3.25,8 C2.5,8 2,8.4 2,9 L2,15 C2,15.6 2.5,16 3.25,16 L20.75,16 C21.5,16 22,15.6 22,15 L22,9 Z M21,15 L3,15 L3,9 L21,9 L21,15 Z" fill-rule="nonzero"></path><rect class="gjs-block-svg-path" x="4" y="11.5" width="16" height="1"></rect></svg><p style="font-size: 10px;"> Button</p></div>',
  content: '<div class="form-group"><button class="button" type="submit">Send</button></div>',
});

blockManager.add('label', {
  label: '<div><svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path class="gjs-block-svg-path" d="M22,11.875 C22,11.35 21.5,11 20.75,11 L3.25,11 C2.5,11 2,11.35 2,11.875 L2,17.125 C2,17.65 2.5,18 3.25,18 L20.75,18 C21.5,18 22,17.65 22,17.125 L22,11.875 Z M21,17 L3,17 L3,12 L21,12 L21,17 Z" fill-rule="nonzero"></path><rect class="gjs-block-svg-path" x="2" y="5" width="14" height="5" rx="0.5"></rect><polygon class="gjs-block-svg-path" fill-rule="nonzero" points="4 13 5 13 5 16 4 16"></polygon></svg><p style="font-size: 10px;"> Label</p></div>',
  content: '<label class="label">Label</label>',
});

blockManager.add('firstName', {
  label: '<div><svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path class="gjs-block-svg-path" d="M22,9 C22,8.4 21.5,8 20.75,8 L3.25,8 C2.5,8 2,8.4 2,9 L2,15 C2,15.6 2.5,16 3.25,16 L20.75,16 C21.5,16 22,15.6 22,15 L22,9 Z M21,15 L3,15 L3,9 L21,9 L21,15 Z"></path><polygon class="gjs-block-svg-path" points="4 10 5 10 5 14 4 14"></polygon></svg><p style="font-size: 10px;"> First Name</p></div>',
  content: '<div class="form-group"><input placeholder="Type here your first name" type="text" required="" name="first_name" class="input"/></div>',
});

blockManager.add('lastName', {
  label: '<div><svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path class="gjs-block-svg-path" d="M22,9 C22,8.4 21.5,8 20.75,8 L3.25,8 C2.5,8 2,8.4 2,9 L2,15 C2,15.6 2.5,16 3.25,16 L20.75,16 C21.5,16 22,15.6 22,15 L22,9 Z M21,15 L3,15 L3,9 L21,9 L21,15 Z"></path><polygon class="gjs-block-svg-path" points="4 10 5 10 5 14 4 14"></polygon></svg><p style="font-size: 10px;"> Last Name</p></div>',
  content: '<div class="form-group"><input placeholder="Type here your last name" type="text" required="" name="last_name" class="input"/></div>',
});

blockManager.add('email', {
  label: '<div><svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path class="gjs-block-svg-path" d="M22,9 C22,8.4 21.5,8 20.75,8 L3.25,8 C2.5,8 2,8.4 2,9 L2,15 C2,15.6 2.5,16 3.25,16 L20.75,16 C21.5,16 22,15.6 22,15 L22,9 Z M21,15 L3,15 L3,9 L21,9 L21,15 Z"></path><polygon class="gjs-block-svg-path" points="4 10 5 10 5 14 4 14"></polygon></svg><p style="font-size: 10px;"> Email</p></div>',
  content: '<div class="form-group"><input placeholder="Type here your email" type="email" required="" name="email" class="input"/></div>',
});

blockManager.add('cellPhone', {
  label: '<div><svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path class="gjs-block-svg-path" d="M22,9 C22,8.4 21.5,8 20.75,8 L3.25,8 C2.5,8 2,8.4 2,9 L2,15 C2,15.6 2.5,16 3.25,16 L20.75,16 C21.5,16 22,15.6 22,15 L22,9 Z M21,15 L3,15 L3,9 L21,9 L21,15 Z"></path><polygon class="gjs-block-svg-path" points="4 10 5 10 5 14 4 14"></polygon></svg><p style="font-size: 10px;"> Phone Number</p></div>',
  content: '<div class="form-group"><input placeholder="Type here your phone number" type="tel" required="" name="cell_phone" class="input"/></div>',
});

blockManager.add('homePhone', {
  label: '<div><svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path class="gjs-block-svg-path" d="M22,9 C22,8.4 21.5,8 20.75,8 L3.25,8 C2.5,8 2,8.4 2,9 L2,15 C2,15.6 2.5,16 3.25,16 L20.75,16 C21.5,16 22,15.6 22,15 L22,9 Z M21,15 L3,15 L3,9 L21,9 L21,15 Z"></path><polygon class="gjs-block-svg-path" points="4 10 5 10 5 14 4 14"></polygon></svg><p style="font-size: 10px;"> Home Number</p></div>',
  content: '<div class="form-group"><input placeholder="Type here your home number" type="tel" required="" name="home_phone" class="input"/></div>',
});

blockManager.add('address1', {
  label: '<div><svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path class="gjs-block-svg-path" d="M22,9 C22,8.4 21.5,8 20.75,8 L3.25,8 C2.5,8 2,8.4 2,9 L2,15 C2,15.6 2.5,16 3.25,16 L20.75,16 C21.5,16 22,15.6 22,15 L22,9 Z M21,15 L3,15 L3,9 L21,9 L21,15 Z"></path><polygon class="gjs-block-svg-path" points="4 10 5 10 5 14 4 14"></polygon></svg><p style="font-size: 10px;"> Address 1</p></div>',
  content: '<div class="form-group"><input placeholder="Type here your address 1" type="text" required="" name="address1" class="input"/></div>',
});

blockManager.add('address2', {
  label: '<div><svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path class="gjs-block-svg-path" d="M22,9 C22,8.4 21.5,8 20.75,8 L3.25,8 C2.5,8 2,8.4 2,9 L2,15 C2,15.6 2.5,16 3.25,16 L20.75,16 C21.5,16 22,15.6 22,15 L22,9 Z M21,15 L3,15 L3,9 L21,9 L21,15 Z"></path><polygon class="gjs-block-svg-path" points="4 10 5 10 5 14 4 14"></polygon></svg><p style="font-size: 10px;"> Address 2</p></div>',
  content: '<div class="form-group"><input placeholder="Type here your address 2" type="text" required="" name="address2" class="input"/></div>',
});

blockManager.add('city', {
  label: '<div><svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path class="gjs-block-svg-path" d="M22,9 C22,8.4 21.5,8 20.75,8 L3.25,8 C2.5,8 2,8.4 2,9 L2,15 C2,15.6 2.5,16 3.25,16 L20.75,16 C21.5,16 22,15.6 22,15 L22,9 Z M21,15 L3,15 L3,9 L21,9 L21,15 Z"></path><polygon class="gjs-block-svg-path" points="4 10 5 10 5 14 4 14"></polygon></svg><p style="font-size: 10px;"> City</p></div>',
  content: '<div class="form-group"><input placeholder="Type here your city" type="text" required="" name="city" class="input"/></div>',
});

blockManager.add('state', {
  label: '<div><svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path class="gjs-block-svg-path" d="M22,9 C22,8.4 21.5,8 20.75,8 L3.25,8 C2.5,8 2,8.4 2,9 L2,15 C2,15.6 2.5,16 3.25,16 L20.75,16 C21.5,16 22,15.6 22,15 L22,9 Z M21,15 L3,15 L3,9 L21,9 L21,15 Z"></path><polygon class="gjs-block-svg-path" points="4 10 5 10 5 14 4 14"></polygon></svg><p style="font-size: 10px;"> State</p></div>',
  content: '<div class="form-group"><input placeholder="Type here your state" type="text" required="" name="state" class="input"/></div>',
});

blockManager.add('country', {
  label: '<div><svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path class="gjs-block-svg-path" d="M22,9 C22,8.4 21.5,8 20.75,8 L3.25,8 C2.5,8 2,8.4 2,9 L2,15 C2,15.6 2.5,16 3.25,16 L20.75,16 C21.5,16 22,15.6 22,15 L22,9 Z M21,15 L3,15 L3,9 L21,9 L21,15 Z"></path><polygon class="gjs-block-svg-path" points="4 10 5 10 5 14 4 14"></polygon></svg><p style="font-size: 10px;"> country</p></div>',
  content: '<div class="form-group"><input placeholder="Type here your country" type="text" required="" name="country" class="input"/></div>',
});

blockManager.add('zip', {
  label: '<div><svg class="gjs-block-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path class="gjs-block-svg-path" d="M22,9 C22,8.4 21.5,8 20.75,8 L3.25,8 C2.5,8 2,8.4 2,9 L2,15 C2,15.6 2.5,16 3.25,16 L20.75,16 C21.5,16 22,15.6 22,15 L22,9 Z M21,15 L3,15 L3,9 L21,9 L21,15 Z"></path><polygon class="gjs-block-svg-path" points="4 10 5 10 5 14 4 14"></polygon></svg><p style="font-size: 10px;"> Zip</p></div>',
  content: '<div class="form-group"><input placeholder="Type here your zip" type="text" required="" name="zip" class="input"/></div>',
});