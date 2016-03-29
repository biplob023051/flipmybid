$(document).ready(function(){
    $.ajaxSetup({
        cache: false
    });

    $('#pageListTop').sortable({
        'axis': 'y',
        'items': 'tr.sortable_top',
        'opacity': 50,
        update: function(){
            $.ajax({
                url: '/admin/pages/saveorder/top',
                type: 'POST',
                data: $(this).sortable('serialize'),
                success: function(data){
                    $('#orderMessageTop').html(data).show('fast').animate({opacity: 1.0}, 2000).fadeOut('slow');
                }
            });
        }
    });

    $('#pageListBottom').sortable({
        'axis': 'y',
        'items': 'tr.sortable_bottom',
        'opacity': 50,
        update: function(){
            $.ajax({
                url: '/admin/pages/saveorder/bottom',
                type: 'POST',
                data: $(this).sortable('serialize'),
                success: function(data){
                    $('#orderMessageBottom').html(data).show('fast').animate({opacity: 1.0}, 2000).fadeOut('slow');
                }
            });
        }
    });

    // For initial load
    var fixedPrice = $('#ProductFixedPrice').val();

    if(fixedPrice == 0){
        $('#ProductFixed').removeAttr('checked');
        $('#FixedPriceBlock').hide(1);
    }else{
        $('#ProductFixed').attr('checked', true);
        $('#FixedPriceBlock').show(1);
    }

    // For change
    $('#ProductFixed').click(function(){
        if($(this).attr('checked')){
            $('#ProductFixedPrice').val(fixedPrice);
            $('#FixedPriceBlock').show(1);
        }else{
            $('#ProductFixedPrice').val(0);
            $('#FixedPriceBlock').hide(1);
        }
    });


    // For initial load
    var rewardPoints = $('#ProductRewardPoints').val();

    if(rewardPoints == 0){
        $('#ProductReward').removeAttr('checked');
        $('#RewardPointsBlock').hide(1);
    }else{
        $('#ProductReward').attr('checked', true);
        $('#RewardPointsBlock').show(1);
    }

    // For change
    $('#ProductReward').click(function(){
        if($(this).attr('checked')){
            $('#ProductRewardPoints').val(rewardPoints);
            $('#RewardPointsBlock').show(1);
        }else{
            $('#ProductRewardPoints').val(0);
            $('#RewardPointsBlock').hide(1);
        }
    });
});
