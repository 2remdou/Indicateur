/**
 * Created by delphinsagno on 15/03/15.
 */
app.controller('UniteController',['$scope','Restangular',function($scope,Restangular){
    var unites = Restangular.all(getRoute('get_unites',{}));
    unites.getList().then(function(u){
        $scope.unites = u;
    });


}]);