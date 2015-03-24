/**
 * Created by delphinsagno on 15/03/15.
 */
app.controller('IndicateurController',['$scope','Restangular','$rootScope','indicateurFactory','typeIndicateurFactory',
    function($scope,Restangular,$rootScope,indicateurFactory,typeIndicateurFactory){
                intercepError(Restangular,$rootScope);
                $rootScope.loading=true;
                    indicateurFactory.getList().then(function(indicateurs){
                        $scope.indicateurs = indicateurs;
                        if(indicateurs.length===0){
                            $rootScope.$broadcast('showMessage',
                                {messages:["Aucune données pour le moment"],
                                    typeAlert:"info"
                                }) ;
                        }
                        $rootScope.loading=false;
                        //$rootScope.$broadcast('onShowMessage');
                    });
                typeIndicateurFactory.getList().then(function(typeIndicateurs){
                    $scope.typeIndicateurs = typeIndicateurs;
                });

                $scope.newIndicateur = {};
                $scope.saveIndicateur = function(){
                    if($scope.method === "PUT"){
                        typeIndicateurFactory.one($scope.newIndicateur.typeIndicateur.id).put('indicateurs',{'id':$scope.newIndicateur.id}).then(function(value){
                        //$scope.newIndicateur.put('indicateurs',{'id':$scope.newIndicateur.id}).then(function(values){
                            $scope.newIndicateur = {};
                            $rootScope.$broadcast('showMessage',
                                {messages:["Modification effectuée"],
                                    typeAlert:"success"
                            }) ;
                        });
                        $scope.method = "POST";
                    }
                    else{
                       typeIndicateurFactory.one($scope.newIndicateur.typeIndicateur.id).post('indicateurs',$scope.newIndicateur).then(function(values){
                           $scope.indicateurs.push($scope.newIndicateur);
                           $scope.newIndicateur = {};
                           $rootScope.$broadcast('showMessage',{
                               messages:["Enregistrement effectué"],
                               typeAlert:"success"
                           });

                       });
                    }

                };

                $scope.editIndicateur = function(indicateur){
                    $scope.newIndicateur = indicateur;
                    console.log($scope.newIndicateur.typeIndicateur);
                    $scope.method = "PUT"
                };

                $scope.deleteIndicateur = function(indicateur){
                    $scope.indicateur=indicateur;
                    indicateur.remove().then(function(u){
                        $rootScope.$broadcast('showMessage',{
                            messages:["Suppression effectuée"],
                            typeAlert:"success"
                        });
                        var index = $scope.indicateurs.indexOf(indicateur);
                        $scope.indicateurs.splice(index,1);
                    });
                }


}]);