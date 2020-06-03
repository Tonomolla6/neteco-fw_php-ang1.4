var neteco = angular.module(
    'neteco', 
    [
        'ngRoute'
    ]
);
neteco.config(['$routeProvider', '$locationProvider',
function ($routeProvider, $locationProvider) {
        $routeProvider
                .when("/", {templateUrl: "frontend/modules/home/view/home.view.html", controller: "mainCtrl",
                    resolve: {
                        names: function (services) {
                            return services.get('home','load_name');
                        },
                        bbreeds: function (services) {
                            return services.get('home','best_breed');
                        }
                    }
                })

                .when("/home/:id", {
                    templateUrl: "frontend/modules/home/view/details.view.html",
                    controller: "detailsBCtrl",
                    resolve: {
                        selbreed: function (services, $route) {
                            return services.get('home', 'load_list', $route.current.params.id);
                        }
                    }
                })

                .when("/home/active_user/:token", {
                    resolve: {
                        recpass: function (services, $route) {
                            console.log($route.current.params.token);
                            return services.put('home','active_user',{'token':JSON.stringify({'token':$route.current.params.token})})
                            .then(function(response){
                                console.log(response);
                                location.href = '#/';
                            });
                        }
                    }
                })

                .when("/contact", {templateUrl: "frontend/modules/contact/view/contact.view.html", controller: "contactCtrl"})

                .when("/adoptions", {
                    templateUrl: "frontend/modules/adoptions/view/adoptions.view.html", 
                    controller: "adoptionsCtrl",
                    resolve: {
                        adoptions: function (services) {
                            return services.get('adoptions', 'load_list','%');
                        },
                        breeds: function (services) {
                            return services.get('adoptions', 'all_breeds');
                        }
                    }
                })

                .when("/ubication", {
                    templateUrl: "frontend/modules/ubication/view/ubication.view.html", 
                    controller: "ubicationCtrl",
                    resolve: {
                        ubications: function (services) {
                            return services.get('ubication', 'load_location');
                        },
                        provinces: function (services) {
                            return services.get('ubication', 'load_prov');
                        }
                    }
                })

                .when("/dogs", {
                    templateUrl: "frontend/modules/dogs/view/dogs.view.html", 
                    controller: "dogsCtrl",
                    resolve: {
                        provinces: function (services) {
                            return services.get('dogs', 'load_provinces');
                        }
                    }
                })

                .when("/login", {
                    templateUrl: "frontend/modules/login/view/login.view.html",controller: "loginCtrl"})

                .when("/login/changepass/:token", {
                    templateUrl: "frontend/modules/login/view/recpass.view.html",
                    controller: "changepassCtrl"
                })

                .when("/profile", {
                    templateUrl: "frontend/modules/login/view/profile.view.html",
                    controller: "profileCtrl",
                    resolve: {
                        infoUser: function (services,localstorageService) {
                            return services.get('login', 'print_user',localstorageService.getUsers());
                        }
                    }
                })
                
                .otherwise("/", {templateUrl: "frontend/modules/home/view/home.view.html", controller: "mainCtrl"});
    }]);
