$(document).ready(function(){

    // Variable to hold auction data
    var auctions = '';
    var auctionObjects = new Array();

    // Collecting auction data, the layer id and auction id
    $('.auction-item').each(function(){
        var auctionId    = $(this).attr('id');
        var auctionTitle = $(this).attr('title');

        if($('#' + auctionId + ' .countdown').length){
            // collect the id for post data
            auctions = auctions + auctionId + '=' + auctionTitle + '&';

            // collect the object
            auctionObjects[auctionId]                           = $('#' + auctionId);
            auctionObjects[auctionId]['flash-elements']         = $('#' + auctionId + ' .bid-price, #' + auctionId+ ' .bid-savings-price, #' + auctionId + ' .bid-savings-percentage, #' + auctionId + ' .closes-on');
            auctionObjects[auctionId]['countdown']              = $('#' + auctionId + ' .countdown');
            auctionObjects[auctionId]['closes-on']              = $('#' + auctionId + ' .closes-on');
            auctionObjects[auctionId]['bid-bidder']             = $('#' + auctionId + ' .bid-bidder');
            auctionObjects[auctionId]['bid-button']             = $('#' + auctionId + ' .bid-button');
            auctionObjects[auctionId]['bid-button-a']           = $('#' + auctionId + ' .bid-button a');
            auctionObjects[auctionId]['bid-button-p']           = $('#' + auctionId + ' .bid-button p');
            auctionObjects[auctionId]['bid-price']              = $('#' + auctionId + ' .bid-price');
            auctionObjects[auctionId]['bid-price-fixed']        = $('#' + auctionId + ' .bid-price-fixed');
            auctionObjects[auctionId]['bid-loading']            = $('#' + auctionId + ' .bid-loading');
            auctionObjects[auctionId]['bid-message']            = $('#' + auctionId + ' .bid-message');
            auctionObjects[auctionId]['bid-flash']              = $('#' + auctionId + ' .bid-flash');
            auctionObjects[auctionId]['bid-savings-price']      = $('#' + auctionId + ' .bid-savings-price');
            auctionObjects[auctionId]['bid-savings-percentage'] = $('#' + auctionId + ' .bid-savings-percentage');
            auctionObjects[auctionId]['bid-bookbidbutler']      = $('#' + auctionId + ' .bid-bookbidbutler');

            auctionObjects[auctionId]['bid-histories']          = $('#bidHistoryTable' + auctionTitle);
            auctionObjects[auctionId]['bid-histories-p']        = $('#bidHistoryTable' + auctionTitle + ' p');
            auctionObjects[auctionId]['bid-histories-tbody']    = $('#bidHistoryTable' + auctionTitle + ' tbody');
        }
    });

    // additional object
    var bidOfficialTime        = $('.bid-official-time');
    var bidBalance             = $('.bid-balance');
    var price                  = '';
    var priceFixed             = '';
    var getstatus_url_time;
    var getstatus_url;
	
	// Change by Andrew Buchan: URL to get buy it price
	var getbuyitprice_url = '/getbuyitprice.php';
	// End Change

    if($('.bid-histories').length){
        getstatus_url = '/getstatus.php?histories=yes&ms=';
    }else{
        getstatus_url = '/getstatus.php?ms=';
    }

    function convertToNumber(sourceString){
        return sourceString.replace(/&#[0-9]{1,};/gi, "")
                            .replace(/&[a-z]{1,};/gi, "")
                            .replace(/[a-zA-Z]+/gi, "")
                            .replace(/[^0-9\,\.]/gi, "");
    }

    // Do the loop when auction available only
    if(auctions) {
        setInterval(function () {
            getstatus_url_time = getstatus_url + new Date().getTime();
            $.ajax({
                url: getstatus_url_time,
                dataType: 'json',
                type: 'POST',
                data: auctions,
                success: function (data) {
                    if (data[0]) {
                        if (data[0].Auction.serverTimeString) {
                            if (bidOfficialTime.html()) {
                                bidOfficialTime.html(data[0].Auction.serverTimeString);
                            }
                        }

                        if (data[0].Balance) {
                            if (bidBalance.html()) {
                                bidBalance.html(data[0].Balance.balance);
                            }
                        }
                    }

                    $.each(data, function (i, item) {
                        if (auctionObjects[item.Auction.element]['bid-price-fixed'].html()) {

                            if (auctionObjects[item.Auction.element]['bid-price-fixed'].length > 1) {
                                auctionObjects[item.Auction.element]['bid-price-fixed'].each(function () {
                                    price = $(this).html();
                                });
                            } else {
                                price = auctionObjects[item.Auction.element]['bid-price-fixed'].html();
                            }

                        } else {

                            if (auctionObjects[item.Auction.element]['bid-price'].length > 1) {
                                auctionObjects[item.Auction.element]['bid-price'].each(function () {
                                    price = $(this).html();
                                });
                            } else {
                                price = auctionObjects[item.Auction.element]['bid-price'].html();
                            }
                        }

                        price = convertToNumber(price);

                        if (auctionObjects[item.Auction.element]['bid-bidder'].html() != item.LastBid.username) {
                            auctionObjects[item.Auction.element]['bid-bidder'].html(item.LastBid.username);
                        }

                        /*
                         if(auctionObjects[item.Auction.element]['bid-bidder'].text()){
                         if(auctionObjects[item.Auction.element]['bid-bidder'].hasClass('username-bid')){
                         auctionObjects[item.Auction.element]['bid-bidder'].removeClass('username-bid').addClass('username');
                         }
                         }
                         */

                        if (price != convertToNumber(item.Auction.price)) {
                            if (item.Auction.show_price) {
                                auctionObjects[item.Auction.element]['bid-price'].html(item.Auction.show_price);
                            } else {
                                auctionObjects[item.Auction.element]['bid-price'].html(item.Auction.price);
                            }

                            auctionObjects[item.Auction.element]['bid-price-fixed'].html(item.Auction.price);

                            if (auctionObjects[item.Auction.element]['bid-flash'] && item.Message) {
                                auctionObjects[item.Auction.element]['bid-flash'].html(item.Message.message).show(1).animate({opacity: 1.0}, 2000).hide(1);
                            }

                            if (auctionObjects[item.Auction.element]['bid-histories'].length) {
                                if (auctionObjects[item.Auction.element]['bid-histories-p'].html()) {
                                    auctionObjects[item.Auction.element]['bid-histories-p'].remove();
                                }

                                auctionObjects[item.Auction.element]['bid-histories-tbody'].empty();

                                $.each(item.Histories, function (n, tRow) {
                                    var row = '<tr><td>' + tRow.Bid.created + '</td><td>' + tRow.User.username + '</td><td>' + tRow.Bid.description + '</td></tr>';

                                    auctionObjects[item.Auction.element]['bid-histories-tbody'].append(row);
                                });

                                auctionObjects[item.Auction.element]['closes-on'].html(item.Auction.closes_on);
                                auctionObjects[item.Auction.element]['bid-savings-percentage'].html(item.Auction.savings.percentage);
                                auctionObjects[item.Auction.element]['bid-savings-price'].html(item.Auction.savings.price);
                            }

                            if ($('#bidUnique' + item.Auction.id).text() && item.Auction.uniqueBids) {
                                $('#bidUnique' + item.Auction.id).html(item.Auction.uniqueBids);
                            }

                            auctionObjects[item.Auction.element]['flash-elements'].effect("highlight", {color: "#FF3300"}, 1500);
                            //auctionObjects[item.Auction.element]['countdown']
                            //.animate({fontSize: "30px", color:"#FF3300"}, 500)
                            //.animate({fontSize: "24px",color:"#000000"}, 500);
                            //auctionObjects[item.Auction.element]['bid-bidder'].removeClass('username').addClass('username-bid');
                        }

                        if (item.Auction.peak_only == 1 && item.Auction.isPeakNow == 0) {
                            auctionObjects[item.Auction.element]['countdown'].html('Paused');

                            auctionObjects[item.Auction.element]['bid-button-a'].hide();
                            if (auctionObjects[item.Auction.element]['bid-button-p'].html() == '') {
                                auctionObjects[item.Auction.element]['bid-button'].append('<p>Peak Only Auction</p>');
                            }
                        } else {
                            if (item.Auction.end_time - item.Auction.serverTimestamp > 0) {
                                if (item.Auction.time_left <= 10) {
                                    auctionObjects[item.Auction.element]['countdown'].css('color', '#ff0000');
                                } else {
                                    auctionObjects[item.Auction.element]['countdown'].removeAttr('style');
                                }
                            }
                        }

                        auctionObjects[item.Auction.element]['countdown'].html(item.Auction.end_time_string);

                        if (item.Auction.time_left <= 0 && item.Auction.closed == 1) {
                            auctionObjects[item.Auction.element]['bid-button'].hide();
                            auctionObjects[item.Auction.element]['bid-bookbidbutler'].hide();

                            if (auctionObjects[item.Auction.element]['bid-button-p'].html()) {
                                auctionObjects[item.Auction.element]['bid-button-a'].show();
                                auctionObjects[item.Auction.element]['bid-button-p'].remove();
                            }
                        }
                    });
                },

                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    // nothing implement here
                    // have an idea?
                }
            });
        }, 1000);

        // Change by Andrew Buchan: Call getbuyitprice.php every 1 second
        setInterval(function () {
            $.ajax({
                url: getbuyitprice_url,
                dataType: 'json',
                type: 'POST',
                data: auctions,
                success: function (data) {
                    console.log(data);
                },

                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    // nothing implement here
                    // have an idea?
                }
            });
            // End change

        });
    }
    // Function for bidding
    $('.bid-button-link').click(function(){
        var auctionElement = 'auction_' + $(this).attr('title');

        auctionObjects[auctionElement]['bid-button'].hide(1);
        auctionObjects[auctionElement]['bid-loading'].show(1);

        $.ajax({
            url: $(this).attr('href') + '&ms=' + new Date().getTime(),
            dataType: 'json',
            success: function(data){
                if(data.Auction.hold == 1){
                	auctionObjects[auctionElement]['bid-message'].html(data.Auction.message)
                                                                 .show(1)
                                                                 .animate({opacity: 1.0}, 60000)
                                                                 .hide(1);
                }
                if(data.Auction.hold == 0){
                	auctionObjects[auctionElement]['bid-message'].html(data.Auction.message)
                                                                 .show(1)
                                                                 .animate({opacity: 1.0}, 1000)
                                                                 .hide(1);
                }


                auctionObjects[auctionElement]['bid-button'].show(1);
                auctionObjects[auctionElement]['bid-loading'].hide(1);
            }
        });

        return false;
    });

    if($('.productImageThumb').length){
        $('.productImageThumb').click(function(){
            $('.productImageMax').fadeOut('fast').attr('src', $(this).attr('href')).fadeIn('fast');
            return false;
        });
    }

    if($('#CategoryId').length){
        $('#CategoryId').change(function(){
            document.location = '/categories/view/' + $('#CategoryId option:selected').attr('value');
        });
    }

    if($('#myselectbox').length){
        $('#myselectbox').change(function(){
            document.location = '/categories/view/' + $('#myselectbox option:selected').attr('value');
        });
    }

	// Function to display drop down menu
	$('ul.sf-menu').superfish({
		delay:       500,
		animation:   {opacity:'show',height:'show'},
		speed:       'fast',
		dropShadows: false
	});
});