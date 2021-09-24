'use strict';

window.addEventListener('load', () => {
  const pickAllUsers = document.getElementById("pickAllUsers");
  const checkboxes = [
    ...document.querySelector("#table-body")
      .querySelectorAll('input[type=checkbox]')
  ];
  const addButton = document.getElementById('addButton');
  const deleteButton = document.getElementById('deleteButton');
  var spanClose = document.getElementById("add-user-close-modal");




  pickAllUsers.addEventListener("click", pickAllUsersAction);
  document.getElementById("table-body")
    .addEventListener("click", tbodyclickAction);
  updateForm.addEventListener("submit", updateUser);
  addForm.addEventListener("submit", addUser);
  addButton.addEventListener("click", requestUserData);
  deleteButton.setAttribute('disabled', checkboxes.every(checkbox => !checkbox.checked));
  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('click', () => {
      pickAllUsers.checked = checkboxes.every(checkbox => checkbox.checked);
      if (checkboxes.every(checkbox => !checkbox.checked)) {
        deleteButton.setAttribute('disabled', true);
      } else {
        deleteButton.removeAttribute('disabled');
      }
    });
  });
  spanClose.addEventListener(
    "click", 
    () => document.getElementById("add-user-modal").style.display = "none"
  );
  deleteButton.addEventListener('click', () => {
    const ids = checkboxes.filter(checkbox => checkbox.checked)
      .map(checkbox => checkbox.getAttribute('id').match(/pickUser(.*)/)[1])
    var body = new FormData();
    ['id','name','pwd','token'].map(property =>
      body.append(property, updateForm[property].value)
    );
    body.append('action', 'delete');
    body.append('ids', ids.map(id => id).join(','));
    fetch('userRequest.php', {method: 'POST', body})
      .then(response => {
        console.log(response);
        if(!response.ok){throw new Error('Petición fallida');}  
        // document.querySelector('#name-'+id).innerText = name;
        // document.querySelector('#pwd-'+id) .innerText = pwd;
        return response.text();
      })
      .then(message => showSnackBar(message))
      .catch(error =>  showSnackBar(error.message, true));
  });

function requestUserData(clickEvent) {
  var modal = document.getElementById("add-user-modal");
  modal.style.display = "block";
}

function pickAllUsersAction(clickEvent){
  var isPickAllUsersChecked = clickEvent.target.checked;
  const checkboxes = [
    ...document.querySelector("#table-body")
      .querySelectorAll('input[type=checkbox]')
  ];
  const deleteButton = document.getElementById('deleteButton');
  checkboxes.forEach(checkbox => checkbox.checked = isPickAllUsersChecked);
  
  if (checkboxes.every(checkbox => !checkbox.checked)) {
    deleteButton.setAttribute('disabled', true);
  } else {
    deleteButton.removeAttribute('disabled');
  }
}

function tbodyclickAction (clickEvent) {
  if (clickEvent.target.parentNode.nodeName == 'BUTTON' && clickEvent.target.parentNode.hasAttribute('data-id')) {
    var modal = document.getElementById("update-user-modal");
    modal.style.display = "block";

    ['name','id','pwd'].map(property =>
      updateForm[property].value = 
        clickEvent.target.parentNode.getAttribute("data-"+property)
    );
  }

  var spanClose = document.getElementById("update-user-close-modal");
  spanClose.addEventListener(
    "click", 
    () => document.getElementById("update-user-modal").style.display = "none"
  );
}

function updateUser(event){
  event.preventDefault();

  var body = new FormData();
  ['id','name','pwd','token'].map(property =>
    body.append(property, updateForm[property].value)
  );
  body.append('action', 'update')
  fetch('userRequest.php', { method: 'POST', body })
  .then(response => {
    console.log(response);
    if(!response.ok){throw new Error('Petición fallida');}  
    // document.querySelector('#name-'+id).innerText = name;
    // document.querySelector('#pwd-'+id) .innerText = pwd;
    return response.text();
  })
  .then(message => showSnackBar(message))
  .catch(error =>  showSnackBar(error.message, true));
}

function addUser(event){
  event.preventDefault();

  var body = new FormData();
  ['name','pwd','token'].map(property =>
    body.append(property, addForm[property].value)
  );
  body.append('action', 'add')
  fetch('userRequest.php', { method: 'POST', body })
  .then(response => {
    console.log(response);
    if(!response.ok){throw new Error('Petición fallida');}  
    // document.querySelector('#name-'+id).innerText = name;
    // document.querySelector('#pwd-'+id) .innerText = pwd;
    return response.text();
  })
  .then(message => showSnackBar(message))
  .catch(error =>  showSnackBar(error.message, true));
}

function showSnackBar(message, isError = false) {
  var snackbar = document.getElementById("snackbar");
  snackbar.innerHTML = message;
  snackbar.className = "show";
  if(isError) {snackbar.classList.add('error');}
  setTimeout(
    () => snackbar.className = 
      snackbar.className.replace("show", ""), 
    3000
  );
}

});