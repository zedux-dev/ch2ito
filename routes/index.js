var express = require('express');
var path = require('path');
var router = express.Router();
var auth = require('./auth');

router.get('/', function (req, res, next) {
    res.sendFile(path.join(__dirname, '../public/home/index.html'));
});

router.use('/dashboard', auth.middleware, express.static('dashboard/dist'))

module.exports = router;
