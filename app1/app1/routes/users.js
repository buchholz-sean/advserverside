var express = require('express');
var router = express.Router();

/* GET users listing. */
router.get('/', function(req, res, next) {
    res.render('form', {
        title: 'Sign Up',
        navitems: [{
            link: '/',
            content: 'Home'
        }, {
            link: '/users',
            content: 'Users'
        }]
    });
});

router.post('/', function(req, res, next) {
    var email = req.body.email;
    var pass = req.body.password;
    var passVerify = req.body.passVerify;
    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regex.test(email)) {
        res.render('form', {
            title: 'Sign Up',
            msg: 'Please enter a valid email address',
            navitems: [{
                link: '/',
                content: 'Home'
            }, {
                link: '/users',
                content: 'Users'
            }]
        })
    } else {
        if (pass != passVerify) {
            res.render('form', {
                title: 'Sign Up',
                msg: 'Passwords do not match',
                navitems: [{
                    link: '/',
                    content: 'Home'
                }, {
                    link: '/users',
                    content: 'Users'
                }]
            });
        } else {
            res.send("Thank you for signing up");
        }
    }

})

module.exports = router;