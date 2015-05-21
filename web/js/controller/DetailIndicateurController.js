/**
 * Created by delphinsagno on 15/03/15.
 */
app.controller('DetailIndicateurController',['$scope','Restangular','$rootScope','indicateurFactory','detailIndicateurFactory','dateFilter',
    function($scope,Restangular,$rootScope,indicateurFactory,detailIndicateurFactory,dateFilter){
                intercepError(Restangular,$rootScope);
                $rootScope.$broadcast('hideMessage') ;
                $scope.all = function(){
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
                }

                $scope.all();

                indicateurFactory.getList().then(function(indicateurs){
                    $scope.indicateurs = indicateurs;
                });

/*
                uniteFactory.getList().then(function(unites){
                    $scope.unites = unites;
                });
*/



                $scope.newDetail = {};
                $scope.saveDetail = function(){
                    console.log($scope.newDetail.dateDetail);
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
                        $scope.newDetail.dateDetail = dateFilter($scope.newDetail.dateDetail,'yyyy-M-d h:mm:ss');
                       //uniteFactory.one($scope.newDetail.unite.id).one(getRoute('get_indicateurs'),$scope.newDetail.indicateur.id).post('details',$scope.newDetail)
                       indicateurFactory.one($scope.newDetail.indicateur.id).post('details',$scope.newDetail)
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

                $scope.editDetail = function(detail){
                    detail.dateDetail = dateFilter(detail.dateDetail,'yyyy-M-d h:mm:ss');
                    //detail.dateDetail = dateFilter(detail.dateDetail,'yyyy-d-M h:mm:ss');
                    $scope.newDetail = detail.dateDetail;
                    $scope.method = "PUT"
                };

                $scope.deleteDetail = function(indicateur){
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
                    $rootScope.loading=true;
                    $scope.newDetail.indicateur.getList(getRoute('get_detail_indicateurs'))
                        .then(function(details){
                        $scope.details = details;
                        if(details.length===0){
                            $rootScope.$broadcast('showMessage',
                                {messages:["Aucun detail pour cet indicateur"],
                                    typeAlert:"info"
                                }) ;
                        }
                        $rootScope.loading=false;
                    });

                };

/*
                $scope.changeUnite = function(){
                    $rootScope.loading=true;
                    $scope.newDetail.unite.getList(getRoute('get_detail_indicateurs'))
                        .then(function(details){
                            $scope.details = details;
                            if(details.length===0){
                                $rootScope.$broadcast('showMessage',
                                    {messages:["Aucun detail pour cette unite"],
                                        typeAlert:"info"
                                    }) ;
                            }
                            $rootScope.loading=false;
                        });

                };
*/

                $scope.filtre = function(){
                    $rootScope.$broadcast('hideMessage')
                  if($scope.newDetail.indicateur && !$scope.newDetail.unite){
                        $scope.changeIndicateur();
                  }
/*
                  else if($scope.newDetail.unite && !$scope.newDetail.indicateur){
                      $scope.changeUnite();
                  }
*/
                  else if($scope.newDetail.indicateur){
                      //uniteFactory.one($scope.newDetail.unite.id).one(getRoute('get_indicateurs'),$scope.newDetail.indicateur.id).getList(getRoute('get_detail_indicateurs'))
                      indicateurFactory.one($scope.newDetail.indicateur.id).getList(getRoute('get_detail_indicateurs'))
                          .then(function(details){
                              $scope.details = details;
                              if(details.length===0){
                                  $rootScope.$broadcast('showMessage',
                                      {messages:["Aucun detail correspondant à ces critères"],
                                          typeAlert:"info"
                                      }) ;
                              }
                              $rootScope.loading=false;

                          });

                  }
                    else{
                      $scope.all();
                  }
                };
                function controlFields(){
                    if(!$scope.newDetail.indicateur){
                        $rootScope.$broadcast('showMessage',{
                            messages:["Veuillez selectionner un indicateur"],
                            typeAlert:"danger"
                        });
                        return false;
                    }
/*
                    if(!$scope.newDetail.unite){
                        $rootScope.$broadcast('showMessage',{
                            messages:["Veuillez selectionner une unite"],
                            typeAlert:"danger"
                        });
                        return false;
                    }
*/
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