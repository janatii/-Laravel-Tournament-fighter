(function(){
    var $sidebar = $('#left-sidebar');
    var $editingSidebar = $('.sidebar-is-editing');
    var $form = $('.sidebar-is-editing form');
    var $bancanopy = $('.bancanopy');
    var $avatarImg = $('#avatarImg');
    var $bannerImg = $('#bannerImg');
    var originalAvatar = $avatarImg.css('background-image');
    var originalBanner = $bannerImg.css('background-image');
    var $changeProfileButton = $('#changeProfileButton');

    $("textarea.profile-description").keyup(function(e) {
        $(this).height(this.scrollHeight - 10);
    });

    $avatarImg.click(function(){
        if ($bancanopy.hasClass('is-editing')) {
            $('#avatarImgFile').trigger('click');
        }
    });
    $('#avatarImgFile').change(function(){
        readURLBG(this, '#avatarImg');
    });

    $bannerImg.click(function(){
        if ($bancanopy.hasClass('is-editing')) {
            $('#bannerImgFile').trigger('click');
        }
    });
    $('#bannerImgFile').change(function(){
        readURLBG(this, '#bannerImg');
    });

    $changeProfileButton.on('click', function(e) {
        e.preventDefault();
        $sidebar.css('display', 'none');
        $editingSidebar.css('display', 'block');
        $bancanopy.addClass('is-editing');
    });

    $('#closeChangeProfileButton').on('click', function(e) {
        e.preventDefault();
        $sidebar.css('display', 'block');
        $editingSidebar.css('display', 'none');
        $form[0].reset();
        $avatarImg.css('background-image', originalAvatar);
        $bannerImg.css('background-image', originalBanner);
        $bancanopy.removeClass('is-editing');
    });
})();
