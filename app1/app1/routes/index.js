var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/', function(req, res, next) {
    res.render('index', {
        title: 'Home',
        navitems: [{
                link: '/',
                content: 'Home'
            },
            {
                link: '/users',
                content: 'Users'
            }
        ]
    });
});

// router.get('/registration', function(req, res, next){
//
// })

module.exports = router;