/**
 * Created by delphinsagno on 15/03/15.
 */
app.controller('DetailIndicateurController',['$scope','Restangular','$rootScope','indicateurFactory','uniteFactory','detailIndicateurFactory',
    function($scope,Restangular,$rootScope,indicateurFactory,uniteFactory,detailIndicateurFactory){
                intercepError(Restangular,$rootScope);
                $rootScope.$broadcast('hideMessage') ;
                $rootScope.loading=true;

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
                indicateurFactory.getList().then(function(indicateurs){
                    $scope.indicateurs = indicateurs;
                });

                uniteFactory.getList().then(function(unites){
                    $scope.unites = unites;
                });



                $scope.newDetail = {};
                $scope.saveDetail = function(){
                    if(!controlFields()) return;
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
                       uniteFactory.one($scope.newDetail.unite.id).one(getRoute('get_indicateurs'),$scope.newDetail.indicateur.id).post('details',$scope.newDetail)
                           .then(function(values){
                           $scope.details.push($scope.newDetail);
                           $scope.newDetail = {};
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

                $scope.changeIndicateur = function(){
                    alert($scope.newDetail.indicateur.libelleIndicateur);
                }
                function controlFields(){
                    if(!$scope.newDetail.indicateur){
                        $rootScope.$broadcast('showMessage',{
                            messages:["Veuillez selectionner un indicateur"],
                            typeAlert:"danger"
                        });
                        return false;
                    }
                    if(!$scope.newDetail.unite){
                        $rootScope.$broadcast('showMessage',{
                            messages:["Veuillez selectionner une unite"],
                            typeAlert:"danger"
                        });
                        return false;
                    }
                    if(!$scope.newDetail.valeur){
                        $rootScope.$broadcast('showMessage',{
                            messages:["Veuillez fournir une valeur"],
                            typeAlert:"danger"
                        });
                        return false;
                    }

                    if(!$scope.newDetail.dateDetail){
                        $rootScope.$broadcast('showMessage',{
                            messages:["Veuillez fournir une date"],
                            typeAlert:"danger"
                        });
                        return false;
                    }

                    return true;
                }



    }]);