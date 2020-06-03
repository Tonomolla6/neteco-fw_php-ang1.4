$( document ).ready(function() {
	// Slider img
	var_img = 1;
	$.ajax({
	  type: 'POST',
	  url: amigable("?module=home&function=slider_img_count"),
	  dataType: 'json'
	}).done(function(result) {
		max_img = result[0]["total"];
		change_img(var_img);
	});

  
	// Slider subcategories
	var_img = 1;
	$.ajax({
	  type: 'POST',
	  url: amigable("?module=home&function=slider_subcategoria"),
	  dataType: 'json',
	  success: function(result){
		for (let i = 0; i < result.length; i++) {
		  $('.subcategorias').html($('.subcategorias').html() +
			'<div id_sub="'+result[i]["id"]+'" id_cat="'+result[i]["category"]+'" class="div subcategoria">'+
			  '<div style="background-image: url(/nueva_final/module/client/module/homepage/view/img/subcategorias.jpg)" class="img"></div>'+
			  '<p>'+result[i]["name"]+'</p>'+
			'</div>');
		}
	  }
	});
  
	// Slider productos
	var_img = 1;
	$.ajax({
	  type: 'POST',
	  url: amigable("?module=home&function=slider_products"),
	  dataType: 'json',
	  success: function(result){
		for (let i = 0; i < result.length; i++) {
		  $('.products').html($('.products').html()+
			'<div id_cat="'+result[i]["category"]+'" id_sub="'+result[i]["subcategory"]+'" id_button="'+result[i]["id"]+'" class="div product">'+
			  '<div style="background-image: url('+result[i]["img"]+')" class="img"></div>'+
			  '<p>'+result[i]["name"]+'</p>'+
			'</div>');
		}
		loop_img();
		clicks();
	  }
	});  
  });
  
  function change_img(id_img) {
	$.ajax({
	  type: "POST",
	  url: amigable("?module=home&function=slider_img_change"),
	  dataType: 'json',
	  data: {id: id_img},
	  success: function(result){
		  if (result.length >= 1){
			$('#homepage_slider').ss("background-image", "url("+result[0]["url"]+")"); 
			$('#homepage_slider div.text h2').html(result[0]["title"]); 
			$('#homepage_slider div.text p').html(result[0]["description"]);
		  }
	}}); 
  }
  
  function loop_img() {
	var_loop_img = setInterval(function(){
	  if (var_img == max_img)
	  var_img = 1;
	  else
		var_img++;
	  change_img(var_img);
	}, 8000);
  }
  
  function clicks() {
	$('.button1 i').on('click', function(){
	  clearInterval(var_loop_img);
	  if (var_img == 1)
		var_img = max_img;
	  else
		var_img--;
	  change_img(var_img);
	  loop_img();
	});
  
	$('.button2 i').on('click', function(){
	  clearInterval(var_loop_img);
	  if (var_img == max_img)
		var_img = 1;
	  else
		var_img++;
	  change_img(var_img);
	  loop_img();
	});
  
	$('.subcategoria').on('click', function(){
	  var sub = this.getAttribute('id_sub');
	  var cat = this.getAttribute('id_cat');
	  localStorage.setItem('subcategory',sub);
	  localStorage.setItem('category',cat);
	  update_clicks("subcategories",sub);
	  window.location.href = amigable("?module=products");
	});
  
	$('.product').on('click', function(){
	  var sub = this.getAttribute('id_sub');
	  var cat = this.getAttribute('id_cat');
	  var id = this.getAttribute('id_button');
	  localStorage.setItem('subcategory',sub);
	  localStorage.setItem('category',cat);
	  localStorage.setItem('product',id);
	  update_clicks("products",id);
	  window.location.href = amigable("?module=products");
	});
  
  }
  
  function update_clicks(table,id) {
	$.ajax({
	  type: "POST",
	  url: amigable("?module=home&function=update_clicks"),
	  dataType: 'json',
	  data: { id: id, table: table }
	});
  }