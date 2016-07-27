angular.module('starter.controllers')
    .controller('ClientViewDeliveryController', ['$scope', '$stateParams', 'ClientOrder', '$ionicLoading', '$ionicPopup', 'UserData',
        function ($scope, $stateParams, ClientOrder, $ionicLoading, $ionicPopup, UserData) {

        var iconUrl = 'http://maps.google.com/mapfiles/kml/pal2';

            $scope.order = {};

            $scope.map = {
                center: {
                    latitude: -27.124557,
                    longitude: -52.619278
                },
                zoom: 17
            };

            $scope.markers = [];
            $ionicLoading.show({
                template: 'Carregando...'
            });

            ClientOrder.get({id: $stateParams.id, include: 'items,cupom'}, function (data) {
                $scope.order = data.data;
                $ionicLoading.hide();
                if (parseInt($scope.order.status, 10) == 1) {
                    initMarkers();
                } else {
                    $ionicPopup.alert({
                        title: 'Advertência',
                        template: 'Seu pedido ainda não saiu para entrega'
                    });
                }
            }, function (dataError) {
                $ionicLoading.hide();
            });

            function initMarkers() {
                var client = UserData.get().client.data,
                    address = client.zipcode + ', ' +
                        client.address + ', ' +
                        client.city + ' - ' +
                        client.state;
                createMarkerClient(address);
            }

            function createMarkerClient(address) {
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    address: address
                }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        var lat = results[0].geometry.location.lat(),
                            long = results[0].geometry.location.lng();

                        $scope.markers.push({
                            id: 'client',
                            coords: {
                                latitude: lat,
                                longitude: long
                            },
                            options: {
                                title: 'Local de entrega',
                                icon: iconUrl + '/icon2.png'
                            }
                        })
                    } else {
                        $ionicPopup.alert({
                            title: 'Advertência',
                            template: 'Endereço não encontrado'
                        });
                    }
                });
            }
        }]);