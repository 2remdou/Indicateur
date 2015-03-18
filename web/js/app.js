/**
 * Created by delphinsagno on 15/03/15.
 */

var app = angular.module('app',[
    'restangular',
    'ngRoute'
]);

app.config(['$routeProvider',function($routeProvider){
   $routeProvider
       .when('/unite',{
           templateUrl: 'js/view/unite.html',
           controller: 'UniteController'
       })
       .otherwise({redirectTo:'/'});
}]);

app.config(function(RestangularProvider){
    RestangularProvider.setBaseUrl(getBaseUrl());
    RestangularProvider.setRequestSuffix('.json');
});

var getRoute = function(routeName,parametres){

    return Routing.generate(routeName,{},false).slice(1);
}
