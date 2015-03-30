/**
 * Created by delphinsagno on 15/03/15.
 */
app.controller('DetailIndicateurController',['$scope','Restangular','$rootScope','indicateurFactory','uniteFactory','detailIndicateurFactory',
    function($scope,Restangular,$rootScope,indicateurFactory,uniteFactory,detailIndicateurFactory){
                intercepError(Restangular,$rootScope);
                $rootScope.$broadcast('hideMessage') ;
                $rootScope.loading=true;
                    indicateurFactory.getList().then(function(indicateurs){
                        $scope.indicateurs = indicateurs;
                    });
                uniteFactory.getList().then(function(unites){
                    $scope.unites = unites;
                });

                detailIndicateurFactory.getList().then(function(details){
                    $scope.details = details;
                    if(details.length===0){
                        $rootScope.$broadcast('showMessage',
                            {messages:["Aucun detail pour le moment"],
                                typeAlert:"info"
                            }) ;
                    }
                    $rootScope.loading=false;

                });

                $scope.newIndicateur = {};
                $scope.saveIndicateur = function(){
                    if($scope.method === "PUT"){
                        $scope.newIndicateur.put().then(function(values){
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