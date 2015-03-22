/**
 * Created by Toure on 21/03/15.
 */
app.factory('typeIndicateurFactory',function(Restangular){
    return Restangular.service(getRoute('get_type_indicateurs'));
});