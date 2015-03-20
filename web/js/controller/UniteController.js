/**
 * Created by delphinsagno on 15/03/15.
 */
app.controller('UniteController',['$scope','Restangular','$rootScope','uniteFactory',
    function($scope,Restangular,$rootScope,uniteFactory){
        $rootScope.loading=true;
        $rootScope.showMessage=false;
        console.log("1"+$rootScope.showMessage);
            uniteFactory.getList().then(function(unites){
                $scope.unites = unites;
                $rootScope.loading=false;
                //$rootScope.$broadcast('onShowMessage');
            });

        $scope.newUnite = {};
        $scope.saveUnite = function(){
            uniteFactory.post($scope.newUnite).then(function(u){
                $scope.unites.push($scope.newUnite);
                $scope.newUnite = {};
                $rootScope.showMessage=true;

                $rootScope.message="Enregistrement effectué";
                $rootScope.typealert="info";
            });
        };

        $scope.editUnite = function(unite){
            $scope.newUnite = unite;
        };

        $scope.deleteUnite = function(unite){

        }
}]);