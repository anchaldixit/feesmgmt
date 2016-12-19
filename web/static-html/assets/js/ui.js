/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    
    
    $('.flip').click(function(){
    $('.card').toggleClass('flipped');
    return false;
    });
    
    $('.tab ul li a').click(function(){
        var id = $(this).attr('href');
        $('.tab ul li a').removeClass('active');
        $(this).addClass('active');
        $('.tab-body').hide();
        $(id).show();
        
        return false;
    });
});




