(function() {


    /**
     * Navigation to 'new' form
     */
    var add_new = document.querySelector(".add-new");
    if(add_new != null) {
        add_new.addEventListener("click", function() {

            window.location.assign(base_url + "add");
        });
    }

    /**
     * Submit the form
     */
    var form_submit = document.querySelector("#form_submit");
    if(form_submit != null) {
        form_submit.addEventListener("click", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var firstname = document.querySelector("#firstname");
            var lastname = document.querySelector("#lastname");
            var phone = document.querySelector("#phone");
            var email = document.querySelector("#email");

            firstname.style.borderColor = "#ced4da";
            lastname.style.borderColor = "#ced4da";
            phone.style.borderColor = "#ced4da";
            email.style.borderColor = "#ced4da";

            var firstname_val = firstname.value.trim();
            var lastname_val = lastname.value.trim();
            var phone_val = phone.value.trim();
            var email_val = email.value.trim();

            if(firstname_val.length == 0) {
                firstname.style.borderColor = "crimson";
                return false;
            }

            if(lastname_val.length == 0) {
                lastname.style.borderColor = "crimson";
                return false;
            }

            if(phone_val.length == 0) {
                phone.style.borderColor = "crimson";
                return false;
            }

            if(email_val.length == 0 || email_val.indexOf("@") == -1) {
                email.style.borderColor = "crimson";
                return false;
            }

            var data = new FormData();
            data.firstname = firstname_val;
            data.lastname = lastname_val;
            data.phone = phone_val;
            data.email = email_val;

            var url = '/add';
            if(document.getElementById("user_id") != null) {
                url = '/user/' + document.getElementById("user_id").value;
            }


            fetch(url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then( (response) => { return response.json() } ).then( json => {

                document.querySelector(".alert").classList.remove("alert-warning");
                document.querySelector(".alert").classList.remove("alert-success");

                document.querySelector(".alert").classList.add("alert-" + json.class);
                document.querySelector(".alert").innerText = json.message;
                document.querySelector(".alert").style.display = "block";

                if(json.success == 1) {

                    setTimeout(function () {
                        window.location.assign(base_url);
                    }, 1500);
                }

            });


        });
    }
/*
    var contact_box = document.querySelectorAll(".contact");
    console.log(contact_box);
    if(contact_box != null) {
        for(var i = 0; i < contact_box.length; i++) {
            contact_box[i].addEventListener("click", function() {

                var user_id = this.dataset.id;
                window.location.assign(base_url + "user/" + user_id);
            });
        }
    }
*/
    /**
     * Load the details/form of the contact
     */
    document.addEventListener("click", function(event) {
        if(event.target.parentElement.classList.contains("contact")) {
            var user_id = event.target.parentElement.dataset.id;
            window.location.assign(base_url + "user/" + user_id);
        }
    });


    /**
     * Delete the contact - bring up the confirmation window
     */
    var delete_button = document.querySelector("span.delete-contact");
    if(delete_button != null) {
        delete_button.addEventListener("click", function(event) {
            document.querySelector(".delete-modal").style.display = "block";
            document.querySelector(".delete-modal").classList.add("animated", "fadeIn");
        });
    }

    /**
     * Cancel the removal - close the popup
     */
    var delete_cancel = document.querySelector(".delete-cancel");
    if(delete_cancel != null) {
        delete_cancel.addEventListener("click", function(event) {
            document.querySelector(".delete-modal").classList.add("animated", "fadeOut");
            setTimeout(function() {
                document.querySelector(".delete-modal").style.display = "none";
                document.querySelector(".delete-modal").classList.remove("animated", "fadeOut");
            }, 1000);

        });
    }

    /**
     * Delete the contact - actual removal, confirmation has been done
     */
    var delete_confirm = document.querySelector(".delete-confirm");
    if(delete_confirm != null) {
        delete_confirm.addEventListener("click", function(event) {

            document.querySelector("#form_submit").disabled = true;

            document.querySelector(".delete-modal").classList.add("animated", "fadeOut");
            setTimeout(function() {
                document.querySelector(".delete-modal").style.display = "none";
                document.querySelector(".delete-modal").classList.remove("animated", "fadeOut");
            }, 1000);

            fetch("/delete/" + document.querySelector("#user_id").value, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: ''
            }).then( (response) => { return response.json() } ).then( json => {

                document.querySelector(".alert").classList.remove("alert-warning");
                document.querySelector(".alert").classList.remove("alert-success");

                document.querySelector(".alert").classList.add("alert-" + json.class);
                document.querySelector(".alert").innerText = json.message;
                document.querySelector(".alert").style.display = "block";

                if(json.success == 1) {

                    setTimeout(function () {
                        window.location.assign(base_url);
                    }, 1500);
                }

            });

        });
    }
})();