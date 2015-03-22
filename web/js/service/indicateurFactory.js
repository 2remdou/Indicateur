/**
 * Created by mdoutoure on 18/03/2015.
 */
app.factory('indicateurFactory',function(Restangular){
    return Restangular.service(getRoute('get_indicateurs'));
});