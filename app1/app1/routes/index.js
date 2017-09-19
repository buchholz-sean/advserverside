var express = require('express');
var router = express.Router();

// General options including page title and navigation items
var options = {
    'title': 'Home',
    'navitems': [{
        'link': '/',
        'content': 'Home'
    }, {
        'link': '/characters',
        'content': 'Characters'
    }]
}

/* GET home page. */
router.get('/', function(req, res, next) {
    res.render('index', options);
});

module.exports = router;
