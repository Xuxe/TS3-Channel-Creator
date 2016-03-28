 /*

              / / ___\ \  | |__  _   _  \ \/ /   ___  _____
             | | |    | | | '_ \| | | |  \  / | | \ \/ / _ \
             | | |___ | | | |_) | |_| |  /  \ |_| |>  <  __/
             | |\____|| | |_.__/ \__, | /_/\_\__,_/_/\_\___|
              \_\    /_/         |___/

          */
 jQuery(document).ready(function($) {
 	$('select').material_select();
 	$(".button-collapse").sideNav();

 	$(window).load(function() {
 		$('#preloader').fadeOut('slow', function() {
 			$(this).remove();
 		}).delay(2000);
 	});


 });

 // -- ANGULAR -- 
 var APP = angular.module('chadd', []);

 APP.config(['$compileProvider', function($compileProvider) {
 	$compileProvider.aHrefSanitizationWhitelist(/^s*(https?|ftp|mailto|ts3server|chrome-extension):/);
 }]);


 APP.controller('chadd', function($scope, $http) {
 	$scope.RESPONSE_HEADER_MSG = "Hi :)";
 	$scope.RESPONSE_MSG = "How are you? Wanna get a channel?";
 	$scope.UUID = "Loading...";

 	$http({
 		method: 'GET',
 		url: 'ajax.php?type=1',
 	}).then(function successCallback(response) {
 		if (response.status == 200) {
 			$scope.RESPONSE_HEADER_MSG = response.data.header;
 			$scope.RESPONSE_MSG = "Hello " + response.data.name + "!";
 			$scope.UUID = response.data.uuid;
 			if($scope.UUID.length >= 1)
 			{
 				$scope.aa = true;
 			}
 			console.log(response.data);
 		}


 	}, function errorCallback(response) {
 		$scope.RESPONSE_HEADER_MSG = "Oops O.o";
 		$scope.RESPONSE_MSG = "The Server does not responed the right way to us. Try it again in some minutes or Contact a Admin.";
 		console.log(response);
 	});


 	$scope.submit = function() {
 		$scope.RESPONSE_HEADER_MSG = "Processing...";
 		$scope.RESPONSE_MSG = "";


 		if ($scope.UUID.length > 28) {
 			$scope.RESPONSE_HEADER_MSG = "Error :(";
 			$scope.RESPONSE_MSG = "The UUID has more than 28 characters!"
 			return;
 		}

 		if ($scope.cname.length > 40) {
 			$scope.RESPONSE_HEADER_MSG = "Error :(";
 			$scope.RESPONSE_MSG = "The Channel Name has more than 40 characters!"
 			return;
 		}

 		if ($scope.password.length > 40) {
 			$scope.RESPONSE_HEADER_MSG = "Error :(";
 			$scope.RESPONSE_MSG = "The Password has more than 40 characters!"
 			return;
 		}

 		var FormData = {
 			'channelname': $scope.cname,
 			'password': $scope.password,
 			'codec': $scope.codec,
 			'quality': $('#quality').val(),
 			'captcha_resp': grecaptcha.getResponse(),
 			'uuid': $scope.UUID,
 		}

 		$http({
 			method: 'POST',
 			url: 'ajax.php?type=0',
 			headers: {
 				'Content-Type': 'application/x-www-form-urlencoded'
 			},
 			data: FormData,
 		}).then(function successCallback(response) {

 			if (response.data.code == 1) {
 				$scope.RESPONSE_HEADER_MSG = response.data.header;
 				$scope.RESPONSE_MSG = "Channel created! Your token: " + response.data.token;
 				$scope.hasConnURL = true;
 				$scope.CONN_URL = response.data.url;
 			} else {
 				$scope.RESPONSE_HEADER_MSG = response.data.header;
 				$scope.RESPONSE_MSG = response.data.msg;
 			}



 		}, function errorCallback(response) {
 			$scope.RESPONSE_HEADER_MSG = "Oops O.o";
 			$scope.RESPONSE_MSG = "The Server does not responed the right way to us. Try it again in some minutes or Contact a Admin.";
 			console.log(response);
 		});


 	};
 });