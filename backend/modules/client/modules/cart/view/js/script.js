var controller_access = true;
function clicks_cart() {
    $('.add_cart').on('click', function () {
        if (controller_access){
            controller_access = false;
            var id = localStorage.getItem('product_cart');
            $('.add_cart').html('Añadiendo...');
            add_cart(id,true);
        }
    });

    $('#finish_cart').on('click', function () {
        if (!localStorage.getItem("token"))
            document.location.href = amigable("?module=login");
        else 
            finish_cart();
    });

    $('#draw_cart').on('click', function () {
        document.location.href = amigable("?module=cart");
    });
    
    $('div.less').on('click', function () {
        var id = this.getAttribute('id_button');
        units(id,false);
    });

    $('div.more').on('click', function () {
        var id = this.getAttribute('id_button');
        units(id,true);
    });

    $('.input_cart').focusout(function() {
        var id = this.getAttribute('id_button');
        units(id,"=");
    });

    $('.total_price i').on('click', function () {
        var id = this.getAttribute('id_button');
        delete_cart(id);
    });
}

function finish_cart() {
    $.ajax({ 
        type: 'POST',
        url: amigable("?module=cart&function=money_checking"),
        data: {
            token: localStorage.getItem("token")
        }
    }).done(function(data) {
        console.log(data);
        $(".pop").css("display","flex");
        $("body").css("overflow","hidden");

        if(data){
            element=
            '<div>'+
                '<i class="green fas fa-check-circle"></i>'+
                '<h2>Pedido realizado correctamente.</h2>'+
            '</div>'+
            '<div id="close_pop" class="cart_button">Cerrar</div>';    
        } else {
            element=
            '<div>'+
                '<i class="red fas fa-times-circle"></i>'+
                '<h2>El pedido no se puede relizar por que no tiene saldo.</h2>'+
            '</div>'+
            '<div id="close_pop" class="cart_button">Cerrar</div>'; 
        }
        $(".pop .pop_page").html(element);
        $('#close_pop').on('click', function () {
            $(".pop").css("display","none");
            $("body").css("overflow-y","auto");
            localStorage.removeItem('cart_list');
            location.reload();
        });
    }).fail(function(textStatus) {
        console.log(textStatus);
    });
}

function cart_user_php(stat) {
    var products_cart = JSON.parse(localStorage.getItem('cart_list'));
    $.ajax({ 
            type: 'POST',
            url: amigable("?module=cart&function=insert_cart_user"),
            data: {
                token: localStorage.getItem("token"),
                data: products_cart
            }
        }).done(function(data) {
            draw_cart(stat);
        }).fail(function(textStatus) {
            console.log("Error en la promesa");
    });
}

function cart_reload(stat_in = false, module = false) {
    if (localStorage.getItem("token")) {
        var select_php = function () {
            return new Promise(function(resolve, reject) {
                $.ajax({ 
                        type: 'POST',
                        url: amigable("?module=cart&function=select_cart_user"),
                        dataType: 'json',
                        data: {
                            token: localStorage.getItem("token")
                        }
                    }).done(function(data) {
                        if (data){
                            var products = new Array();
                            for (let i = 0; i < data.length; i++) {
                                products[i] =  { id: data[i]["product"], und: parseInt(data[i]["units"]) };
                            }
                            localStorage.setItem('cart_list',JSON.stringify(products));
                            resolve(data);
                        } else {
                            localStorage.removeItem('cart_list');
                            resolve(data);
                        }
                    }).fail(function(textStatus) {
                        console.log("Error en la promesa");
                });
            });
        }
        select_php().then(function(data){
            draw_cart(stat_in,module);
        });
    } else
        draw_cart(stat_in,module);
}

function add_cart(id,stat = false,operation = true) {
    if (!localStorage.getItem('cart_list')) {
        var products = [
            { id: id, und: 1 }
        ]
        localStorage.setItem('cart_list',JSON.stringify(products));
    } else {
        var products_cart = JSON.parse(localStorage.getItem('cart_list'));
        let check = products_cart.find((o, i) => {
            if (o.id === id) {
                if (operation === true)
                    products_cart[i] = { id: id, und: (products_cart[i].und+1) };
                else if (!operation)
                    products_cart[i] = { id: id, und: (products_cart[i].und-1) };
                else
                    products_cart[i] = { id: id, und: operation };
                localStorage.setItem('cart_list',JSON.stringify(products_cart));
                return true;
            }
        });

        if (!check) {
            products_cart[products_cart.length] = { id: id, und: 1 };
            localStorage.setItem('cart_list',JSON.stringify(products_cart));
        }
    }
    if (login() == false)
        cart_reload(stat);
    else
        cart_user_php(stat);
}

function delete_cart(id) {
    var products_cart = JSON.parse(localStorage.getItem('cart_list'));
    for (let d = 0; d < products_cart.length; d++) {
        if (products_cart[d].id == id){
            products_cart.splice(d,1);
            break;
        }
    }
    if (products_cart.length == 0) {
        localStorage.removeItem('cart_list');
    } else
        localStorage.setItem('cart_list',JSON.stringify(products_cart));

    if (login() != false)
        cart_user_php();
    else
        cart_reload();
}

function getURL(param) {
    var URLactual = window.location.pathname;
    total = URLactual.split('/')
    if (total[2] == param)
        return true;
    else
        return false;
}

function draw_cart(stat_in = false, module = false) {
    if (getURL("cart"))
        module = true;

    var products_cart = JSON.parse(localStorage.getItem('cart_list'));

    if (!products_cart) {
        $('#cart p.num').html('Cesta&nbsp(0)');
        $('#cart .cart_products').html('<p class="error">El carrito esta vacio...</p>');
        $('.products table').html("No hay productos en tu cesta");
        $('.total_finish p').html('0€');
        $('.total_finish p.units').html('Total (0 productos):');
    } else {
        var data = "";
        for (let i = 0; i < products_cart.length; i++) {
            if (i == 0)
                data = products_cart[i].id;
            else 
                data = data + ',' + products_cart[i].id;
        }
        var cart_reload_promise = function () {
            return new Promise(function(resolve, reject) {
                $.ajax({ 
                        type: 'POST',
                        url: amigable("?module=cart&function=list_products"),
                        dataType: 'json',
                        data: { 
                            data: data 
                        }
                    }).done(function(data) {
                        resolve(data);
                    }).fail(function(textStatus) {
                        console.log("Error en la promesa");
                });
            });
        }

        cart_reload_promise().then(function(data) {
            if (stat_in) {
                setTimeout(function(){ 
                    $('#cart .cart_products').css('transform','translateX(0px)');
                    $('.add_cart').html('Añadir a la cesta');
                    setTimeout(function(){ 
                        $('#cart .cart_products').css('transform','translateX(400px)'); 
                        controller_access = true;
                    }, 2000);
                }, 500);
            }
            // Cart module

            var element = "";
            var total = 0;
            var unidades = 0;
            var stat = "";


            if (module) {
                var table = 
                '<tr>'+
                    '<th>Articulo</th>'+
                    '<th>Precio</th>'+
                    '<th>Unidades</th>'+
                    '<th>Total</th>'+
                '</tr>';

                for (let i = 0; i < data.length; i++) {
                    let units = products_cart.find((o, z) => {
                        if (o.id === data[i]["id"])
                            return products_cart[z];
                    })
                    if (data[i]["stock"] == 0 ){
                        stat = '<span class="less">No hay stock de este producto.</span>';
                        units.und = 0;
                    }else{
                        stat = '<span class="plus">Hay stock de este producto.</span>';
                    }
                    unidades += parseInt(units.und);
                    total += parseInt(units.und) * parseFloat(data[i]["sale_price"]);

                    table += 
                    '<tr id="'+data[i]["id"]+'">'+
                        '<td>'+
                            '<div class="img" style="background-image: url('+data[i]["img"]+')"></div>'+
                            '<div class="description">'+
                                '<p>'+data[i]["name"]+'</p>'+
                                '<hr>'+
                                stat+
                            '</div>'+
                        '</td>'+
                        '<td>'+data[i]["sale_price"]+'€</td>'+
                        '<td>'+
                            '<div class="price">'+
                                '<div id_button="'+data[i]["id"]+'" class="less">-</div>'+
                                '<input id_button="'+data[i]["id"]+'" class="input_cart" name="units" type="number" value="'+units.und+'" />'+
                                '<div id_button="'+data[i]["id"]+'" class="more">+</div>'+
                            '</div>'+
                        '</td>'+
                        '<td class="total_price">'+floor2d(units.und*data[i]["sale_price"])+'€'+
                        '<i id_button="'+data[i]["id"]+'" class="fas fa-times"></i></td>'+
                    '</tr>';
                }
                $('.total_finish p').html(floor2d(total)+'€');
                $('.total_finish p.units').html('Total ('+unidades+' productos):');
                $('.products table').html(table);
            }

            // Cart
            $('#cart .cart_products').html('<div class="cart_products_list">'+
            '</div>'+
            '<div class="cart_total">'+
                '<p>(0) Unidades</p>'+
                '<strong>Total: 0,00</strong>'+
            '</div>'+
            '<div id="draw_cart" class="cart_button">Finalizar compra</div>');

            total = 0;
            unidades = 0;
            for (let x = 0; x < data.length; x++) {
                let units = products_cart.find((o, i) => {
                    if (o.id === data[x]["id"])
                        return products_cart[i];
                })

                if (data[x]["stock"] == 0 ){
                    stat = '<p class="less">No hay stock de este producto.</p>';
                    units.und = 0;
                } else
                    stat = '<p class="plus">Hay stock de este producto.</p>';

                unidades += parseInt(units.und);
                total += parseInt(units.und) * parseFloat(data[x]["sale_price"]);
                element += '<div class="cart_product">'+
                    '<div style="background-image: url('+data[x]["img"]+')" class="img"></div>'+
                    '<div class="data">'+
                        '<h2>'+data[x]["name"]+'</h2>'+
                        '<h3>'+units.und+' x '+data[x]["sale_price"]+'€</h3>'+
                        stat+
                    '</div>'+
                '</div>'+
                '<hr>';
            }
            $('#cart p.num').html('Cesta&nbsp('+unidades+')');
            $('#cart .cart_total p').html("("+unidades+")" + " Unidades");
            $('#cart .cart_products .cart_products_list').html(element);
            $('#cart .cart_total strong').html("Total " + floor2d(total) + "€");
            clicks_cart();
        });
    }
}


function floor2d(numero) {
    var resultado = Math.round(numero*100)/100;
    return resultado;
}

function units(id_in,stat) {
    var change_unit = function () {
        return new Promise(function(resolve, reject) {
            $.ajax({
                type: 'POST',
                url: amigable("?module=cart&function=stock_checking"),
                dataType: "json",
                data: { 
                    id: id_in 
                },
            }).done(function(result) {
                var value = parseInt($('tr#'+id_in+' input').val());
                if (value < 1) 
                    $('tr#'+id_in+' input').val(0);
                else if (value <= result[0].stock) {
                    if (stat == true){
                        if (value < result[0].stock)
                            add_cart(id_in);
                    } else if (!stat) {
                        if (value > 1)
                            add_cart(id_in,false,false);
                    } else
                        add_cart(id_in,false,value);
                } else {
                    add_cart(id_in,false,result[0].stock);
                }
                resolve(result);
            }).error(function(result) {
                console.log(result);
            });
        });
    }

    change_unit().then(function(result) {
        cart_reload();
    });
}