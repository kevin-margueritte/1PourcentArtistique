myApp.controller('search', function ($scope, $http, $window) {
	/*Array containing all data*/
	var allData = {
		"arts": [
		],
		"location": [
		]
	}

	/*Get informations about arts in the databases*/
    var rqt = {
		method : 'GET',
		url : '/php/manager/getAllArtsForSearch.php', 
		headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt).success(function(data){
    	/*Create the different objects in the array "allData.arts"*/
    	for(var i = 0; i<data.key.length; i++){
    		var newArt = new Object();
    		newArt.name = data.key[i].name;
			newArt.creationYear = data.key[i].creationyear;
			newArt.auteurs = data.key[i].auteurs;
    		allData.arts[i] = newArt;
    	}
    });

    /*Get informations about location in the databases*/
    var rqt = {
		method : 'GET',
		url : '/php/manager/getAllLocation.php', 
		headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt).success(function(data){
    	/*Create the different objects in the array "allData.location"*/
    	for(var i = 0; i<data.key.length; i++){
    		var newLocation = new Object();
			newLocation.name = data.key[i].name;
			newLocation.longitude = data.key[i].longitude;
			newLocation.latitude = data.key[i].latitude;
    		allData.location[i] = newLocation;
    	}
    });


	var path; /*Path for the redirection when clicked*/
    var options = {
	    data: allData, /*Get the data*/
	    placeholder: "Chercher un lieu ou une oeuvre d'art...",
	    getValue: "name",
	    /*Defined what will be displayed on the bar
		It's different if it is an art or a place*/
	    template: {
			type: "custom",
			method: function(value, item) {
				var res = value;
				if(item.creationYear != null) {
					res += " <span>(" +item.creationYear+")</span>";
				}
				if(item.auteurs != null) {
					res+= ", <span>" + item.auteurs + "</span>";
				}
				return res;
			}
		},

		/*Defined the two categories*/
	    categories: [ 
	        {
	            listLocation: "arts",
	            header: "<span>Œuvres</span>"
	        },
	        { 
	            listLocation: "location",
	            header: "<span>Lieux</span>"
	        }
	    ],

	    list: {
	    	match: {
	    		enabled: true
	    	},
			onClickEvent: function() {
				//retrieve JSON to which the user clicked
				var value = $(".basics").getSelectedItemData();
				/*Test if it has coordinates (longitude, latitude),
				if yes then have to redirect to homepage if not then have to redirect to art page*/
				if(value.longitude != null && value.latitude) {
					var lng = value.longitude;
					var lat = value.latitude;
					var path = '/?longitude=' + lng + '&latitude=' + lat;
		            $window.location.href = path;
				}
				else {
					var nameArt = value.name.replace(new RegExp(" ", 'g'), "_");
		            var path = '/art/read/' + nameArt;
		            $window.location.href = path;
				}
			},
	        showAnimation: {
				type: "fade",
				time: 400,
				callback: function() {}
			},
			hideAnimation: {
				type: "slide",
				time: 400,
				callback: function() {}
			},
        }
	};
	/*Link the autocomplete function with the search bar*/
	$(".basics").easyAutocomplete(options);
});