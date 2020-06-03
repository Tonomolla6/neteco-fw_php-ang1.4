// Define a new module for our app
var app = angular.module("instantSearch", []);

// Create the instant search filter
app.filter('searchFor', function(){

	// All filters must return a function. The first parameter
	// is the data that is to be filtered, and the second is an
	// argument that may be passed with a colon (searchFor:searchString)
	return function(arr, searchString){
		if(!searchString){
			return arr;
		}

		var result = [];
		searchString = searchString.toLowerCase();
		// Using the forEach helper method to loop through the array
		angular.forEach(arr, function(item){
			if(item.title.toLowerCase().indexOf(searchString) !== -1){
				result.push(item);
			}
		});
		return result;
	};
});

function InstantSearchController($scope){
	$scope.items = [
		{
			url: 'http://tutorialzine.com/2013/07/50-must-have-plugins-for-extending-twitter-bootstrap/',
			title: '50 Must-have plugins for extending Twitter Bootstrap',
			image: 'https://avatars3.githubusercontent.com/u/2159051?v=4'
		},{
			url: 'http://tutorialzine.com/2013/08/simple-registration-system-php-mysql/',
			title: 'Making a Super Simple Registration System With PHP and MySQL',
			image: 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Topeka-polymer.svg/1024px-Topeka-polymer.svg.png'
		},{
			url: 'http://tutorialzine.com/2013/08/slideout-footer-css/',
			title: 'Create a slide-out footer with this neat z-index trick',
			image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ-chi03JKZuqm98tFrYnODe4ntLoOM5qzpN2PSt8tZzSkZ3fHw'
		},{
			url: 'http://tutorialzine.com/2013/06/digital-clock/',
			title: 'How to Make a Digital Clock with jQuery and CSS3',
			image: 'https://i1.wp.com/www.mikecann.co.uk/wp-content/uploads/2014/11/head.png?resize=748%2C399&ssl=1'
		},{
			url: 'http://tutorialzine.com/2013/05/diagonal-fade-gallery/',
			title: 'Smooth Diagonal Fade Gallery with CSS3 Transitions',
			image: 'https://i.pinimg.com/736x/7c/7b/81/7c7b81b825fc8323172b16cf293e7e48--polymers.jpg'
		},{
			url: 'http://tutorialzine.com/2013/05/mini-ajax-file-upload-form/',
			title: 'Mini AJAX File Upload Form',
			image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ-chi03JKZuqm98tFrYnODe4ntLoOM5qzpN2PSt8tZzSkZ3fHw'
		},{
			url: 'http://tutorialzine.com/2013/04/services-chooser-backbone-js/',
			title: 'Your First Backbone.js App – Service Chooser',
			image: 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bc/Topeka-polymer.svg/1024px-Topeka-polymer.svg.png'
		}
	];
}
