(function ($, window, document) {
    'use strict';

    var url_params = new URLSearchParams(location.search);
    var page = {
        init: function () {
            page.filter_jobs();
            page.filter_resources();
            page.filter_events();
            page.filter_news();
            page.filter_professionals();
            page.load_leadership();
            page.pagination();
        },
        filter_jobs: function() {
            $('#jobs-filter').on('click', '.button', function(e){
                e.preventDefault();
                var data = $('#jobs-filter').serialize();

                $.ajax({
                    url: ajaxvars.ajaxurl,
                    data: {
                        action : 'load_jobs',
                        data_attr : data,
                        paged : 1
                    },
                    type: 'POST',
                    success: function success(response) {
                        if (response) {
                            $('.search-results-list').html(response.content);
                            $('.pagination').html(response.pagination);
                        }
                    }
                });
            });
        },
        filter_resources: function() {
            $('#resources-filter').on('change', 'select', function(e){
                e.preventDefault();
                var data = $('#resources-filter').serialize();

                $.ajax({
                    url: ajaxvars.ajaxurl,
                    data: {
                        action : 'load_resources',
                        data_attr : data,
                        paged : 1
                    },
                    type: 'POST',
                    success: function success(response) {
                        if (response) {
                            $('.resources-list').html(response.content);
                            $('.pagination').html(response.pagination);
                        }
                    }
                });
                window.history.replaceState({}, "", "" + params.base_url);
            });

            $('.keyword-holder').on('click', '.button', function(e){
                e.preventDefault();
                var search = $('.keyword-holder').find('input[name="keyword-input"]').val();

                $.ajax({
                    url: ajaxvars.ajaxurl,
                    data: {
                        action: "load_resources",
                        search: search,
                        paged: 1
                    },
                    type: "POST",
                    success: function success(response) {
                        if (response) {
                            $('.resources-list').html(response.content);
                            $('.pagination').html(response.pagination);
                        }
                    }
                });
                window.history.replaceState({}, "", "" + params.base_url);
            });
        },
        filter_events: function() {
            $('#events-filter').on('change', 'select', function(e){
                e.preventDefault();
                var data = $('#events-filter').serialize();

                $.ajax({
                    url: ajaxvars.ajaxurl,
                    data: {
                        action : 'load_events',
                        data_attr : data,
                        paged : 1
                    },
                    type: 'POST',
                    success: function success(response) {
                        if (response) {
                            $('.events-list').html(response.content);
                            $('.pagination').html(response.pagination);
                        }
                    }
                });
            });

            $('.keyword-holder').on('click', '.button', function(e){
                e.preventDefault();
                var search = $('.keyword-holder').find('input[name="keyword-input"]').val();

                $.ajax({
                    url: ajaxvars.ajaxurl,
                    data: {
                        action: "load_events",
                        search: search,
                        paged: 1
                    },
                    type: "POST",
                    success: function success(response) {
                        if (response) {
                            $('.events-list').html(response.content);
                            $('.pagination').html(response.pagination);
                        }
                    }
                });
            });
        },
        filter_news: function() {
            $('#news-filter').on('change', 'select', function(e){
                e.preventDefault();

                var data = $('#news-filter').serialize();

                $.ajax({
                    url: ajaxvars.ajaxurl,
                    data: {
                        action : 'load_news',
                        data_attr : data,
                        paged : 1
                    },
                    type: 'POST',
                    success: function success(response) {
                        if (response) {
                            $('.news-grid').html(response.content);
                            $('.pagination').html(response.pagination);
                        }
                    }
                });
                window.history.replaceState({}, "", "" + params.base_url);
            });

            $('.keyword-holder').on('click', '.button', function(e){
                e.preventDefault();
                var search = $('.keyword-holder').find('input[name="keyword-input"]').val();

                $.ajax({
                    url: ajaxvars.ajaxurl,
                    data: {
                        action: "load_news",
                        search: search,
                        paged: 1
                    },
                    type: "POST",
                    success: function success(response) {
                        if (response) {
                            $('.news-grid').html(response.content);
                            $('.pagination').html(response.pagination);
                        }
                    }
                });
                window.history.replaceState({}, "", "" + params.base_url);
            });
        },
        filter_professionals: function() {
            $('#professionals-filter').on('change', 'select', function(e){
                e.preventDefault();
                var data = $('#professionals-filter').serialize();

                $.ajax({
                    url: ajaxvars.ajaxurl,
                    data: {
                        action : 'load_team',
                        data_attr : data,
                        paged : 1
                    },
                    type: 'POST',
                    success: function success(response) {
                        if (response) {
                            $('.search-result').html(response.message);
                            $('.team-list').html(response.content);

                            if (response.button !== ''){
                                $('.professionals .more').show();
                                $('.professionals .load-more').attr('data-paged', response.button);
                            } else {
                                $('.professionals .more').hide();
                            }
                        }
                    }
                });
            });

            $('#professionals-filter').on('click', '.button', function(e){
                e.preventDefault();
                var data = $('#professionals-filter').serialize();

                $.ajax({
                    url: ajaxvars.ajaxurl,
                    data: {
                        action : 'load_team',
                        data_attr : data,
                        paged : 1
                    },
                    type: 'POST',
                    success: function success(response) {
                        if (response) {
                            $('.search-result').html(response.message);
                            $('.team-list').html(response.content);

                            if (response.button !== ''){
                                $('.professionals .more').show();
                                $('.professionals .load-more').attr('data-paged', response.button);
                            } else {
                                $('.professionals .more').hide();
                            }
                        }
                    }
                });
            });

            $('#professionals-filter #name').keypress(function(e) {
                var key = e.which;
                if (key == 13) {
                    $('#professionals-filter .button').click();
                    return false;
                }
            });

            $('#professionals-filter').on('click', '.clear', function(e){
                e.preventDefault();
                $('#professionals-filter')[0].reset();
                var data = $('#professionals-filter').serialize();

                $('.alphabet-list a').each(function() {
                    $(this).removeClass('active');
                });

                $.ajax({
                    url: ajaxvars.ajaxurl,
                    data: {
                        action : 'load_team',
                        data_attr : data,
                        paged : 1
                    },
                    type: 'POST',
                    success: function success(response) {
                        if (response) {
                            $('.search-result').html(response.message);
                            $('.team-list').html(response.content);

                            if (response.button !== ''){
                                $('.professionals .more').show();
                                $('.professionals .load-more').attr('data-paged', response.button);
                            } else {
                                $('.professionals .more').hide();
                            }
                        }
                    }
                });
            });

            $('.alphabet-list').on('click', 'a', function(e){
                e.preventDefault();
                var data = $('#professionals-filter').serialize();
                var sort_by;

                $('.alphabet-list a').each(function() {
                    $(this).removeClass('active');
                });

                $(this).addClass('active');
                sort_by = $(this).text();

                $.ajax({
                    url: ajaxvars.ajaxurl,
                    data: {
                        action : 'load_team',
                        data_attr : data,
                        sort_by: sort_by,
                        paged : 1
                    },
                    type: 'POST',
                    success: function success(response) {
                        if (response) {
                            $('.search-result').html(response.message);
                            $('.team-list').html(response.content);

                            if (response.button !== ''){
                                $('.professionals .more').show();
                                $('.professionals .load-more').attr('data-paged', response.button);
                            } else {
                                $('.professionals .more').hide();
                            }
                        }
                    }
                });
            });

            $('.professionals .more').on('click', '.load-more', function(e){
                e.preventDefault();
                var data = $('#professionals-filter').serialize();
                var paged = $(this).attr('data-paged');
                var sort_by;

                sort_by = $('.alphabet-list .active').text();

                if (paged != 0) {
                    $.ajax({
                        url: ajaxvars.ajaxurl,
                        data: {
                            action : 'load_team',
                            data_attr : data,
                            sort_by: sort_by,
                            paged : paged
                        },
                        type: 'POST',
                        success: function success(response) {
                            if (response) { console.log(response.button);
                                $('.search-result').html(response.message);
                                $('.team-list .item:last-child').after(response.content);

                                if (response.button !== ''){
                                    $('.professionals .load-more').attr('data-paged', response.button);
                                } else {
                                    $('.professionals .load-more').attr('data-paged', 0);
                                }
                            }
                        }
                    });
                }
            });
        },
        load_leadership: function() {
            $('.leadership .more').on('click', 'a', function(e){
                var offset = $('.leadership .more a').attr('data-number');
                var post_id = $('.leadership .more a').attr('data-post-id');

                $.ajax({
                    url: ajaxvars.ajaxurl,
                    data: {
                        action : 'load_leadership',
                        offset : offset,
                        post_id : post_id
                    },
                    type: 'POST',
                    success: function success(response) {
                        if (response) {
                            $('.team-list .item:last-child').after(response.content);

                            if (response.button !== ''){
                                $('.leadership .more a').attr('data-number', response.button);
                            } else {
                                $('.leadership .more').remove();
                            }
                        }
                    }
                });
            });
        },
        pagination: function() {
            $('.pagination').on('click', '.page-numbers', function(e){
                e.preventDefault();
                var paged = $(this).attr('data-num');
                var action;
                var data;

                switch (1) {
                    case $('#jobs-filter').length :
                        action = 'load_jobs';
                        data = $('#jobs-filter').serialize();
                        break;
                    case $('#resources-filter').length :
                        action = 'load_resources';
                        data = $('#resources-filter').serialize();
                        break;
                    case $('#events-filter').length :
                        action = 'load_events';
                        data = $('#events-filter').serialize();
                        break;
                    case $('#news-filter').length :
                        action = 'load_news';
                        data = $('#news-filter').serialize();
                        break;
                }

                if (paged > 0) {
                    $.ajax({
                        url: ajaxvars.ajaxurl,
                        data: {
                            action : action,
                            data_attr : data,
                            paged : paged
                        },
                        type: "POST",
                        success: function success(response) {
                            if (response) {
                                switch (1) {
                                    case $('#resources-filter').length:
                                        $('.resources-list').html(response.content);
                                        break;
                                    case $('#jobs-filter').length:
                                        $('.search-results-list').html(response.content);
                                        break;
                                    case $('#events-filter').length:
                                        $('.events-list').html(response.content);
                                        break;
                                    case $('#news-filter').length:
                                        $('.news-grid').html(response.content);
                                        break;
                                }
                                $('.pagination').html(response.pagination);
                            }
                        }
                    });
                }
            });
        },
        load: function () {
        },
        resize: function () {
        },
        scroll: function () {
            if ($('.load-more').length) {
                var windowHeight = $(window).height();
                var btnTop = $('.load-more')[0].offsetTop;

                if ($(this).scrollTop() + windowHeight >= btnTop) {
                    clearTimeout($.data(this, 'scrollCheck'));
                    $.data(this, 'scrollCheck', setTimeout(function () {
                        $('.load-more').click();
                    }, 200));
                }
            }
        }
    };

    $(document).ready(page.init);
    $(window).on({
        'load': page.load,
        'resize': page.resize,
        'scroll': page.scroll
    });
})(jQuery, window, document);