const express = require("express");
const app = express();

//app.use(middleware0);  //means that middleware0 will always run before any other exFunc
//app.use(middleware1);  //middleware1 is added to this sequence
//app.use(errorHandler1); //another middleware. but thison eto cath errorr. It should be at the last

//req = requestObject
//res = responseObject
//next = nextMiddleware

//root
app.get('/', (req, res, next) => {
    console.log('This is the ROOT');
    res.send('<h1>Root function</h1>');
})


function expFunc(req, res, next){
    console.log('I am Express Function');
    console.log(req.customVariable)
    res.send('<h1>Express function called</h1>');
    next();
}

function middleware0(req, res, next){
    console.log('I am Middleware Zero');
    next();
}

function middleware1(req, res, next){
    console.log('I am Middleware 1');
    next();
}

function middleware2(req, res, next){
    console.log('I am Middleware 2');
    req.customVariable = 100;
    next();
}


function middleware3(req, res, next){
    console.log('I am Middleware Three');
    console.log(req.customVariable);
    req.customVariable = 200;
    next();
    //const errObj = new Error('I am an error');
    //next(errObj);
}


//error handler middleaware takes extra parameters
function errorHandler1 (err, req, res, next){
    if (err){
        res.send('<h1>There was an error</h1>');
        //or
        //res.json( { err: err} );
    }
}


app.get('/test', middleware1, middleware2, expFunc);

app.get('/test2', middleware2, expFunc);
app.get('/test3', middleware2, middleware3, expFunc);
app.listen(3000);
