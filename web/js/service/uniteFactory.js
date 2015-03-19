/**
 * Created by mdoutoure on 18/03/2015.
 */
app.factory('uniteFactory',function(Restangular){
    return Restangular.service(getRoute('get_unites'));
});