/**
 * Created by delphinsagno on 15/03/15.
 */
app.controller('UniteController',['$scope','Restangular','$rootScope',function($scope,Restangular,$rootScope){
    $rootScope.afficheMessage=false;
    var unites = Restangular.all(getRoute('get_unites',{}));
    unites.getList().then(function(u){
        $scope.unites = u;
    });
    $scope.newUnite = {};
    $scope.saveUnite = function(){
        unites.post($scope.newUnite).then(function(u){
            $scope.unites.push($scope.newUnite);
        },function(msg){
            $rootScope.afficheMessage=true;
            $rootScope.message=msg.statusText;
        });
    };

    $scope.editUnite = function(){

    };

    $scope.deleteUnite = function(){

    }
}]);