var express = require('express');
var router = express.Router();
// sha1 is not a good idea for hashing passwords in production!
// I am only using sha1 here as an example for this assignment
var sha1 = require('sha1');

// General options including page title and navigation items
var options = {
    'title': 'Users',
    'navitems': [{
        'link': '/',
        'content': 'Home'
    }, {
        'link': '/users',
        'content': 'Users'
    }]
}

// GET registration form
router.get('/', function(req, res, next) {
    options.msg = null;
    res.render('form', options);
});

// POST registration form data
router.post('/', function(req, res, next) {
    // Initialize a blank user object
    // This may be used to push an object to a database in the future
    var user = {
        username: '',
        email: '',
        password: ''
    };
    // Get values of input fields
    var usernameInput = req.body.username;
    var emailInput = req.body.email;
    var passInput = req.body.password;
    var passVerifyInput = req.body.passVerify;
    // Basic email regex pattern
    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    // Ensure all fields are filled out
    if (usernameInput == '' || emailInput == '' || passInput == '' || passVerifyInput == '') {
        // This should never happen thanks to HTML5 form field 'required' param
        options.msg = 'Please fill out all fields';
        res.render('form', options)
    } else {
        // Ensure email address is proper format
        if (!regex.test(emailInput)) {
            options.msg = 'Please enter a valid email address';
            res.render('form', options)
        } else {
            // Ensure password and password verification match
            if (passInput != passVerifyInput) {
                options.msg = 'Passwords do not match';
                res.render('form', options);
            } else {
                // Assign input values to user object
                user.username = usernameInput;
                user.email = emailInput;
                user.password = sha1(passInput);
                // Add user details to options passed to view
                options.name = user.username;
                options.email = user.email;
                // Render userHome
                res.render('userHome', options)
            }
        }
    }

})

module.exports = router;