

const Checkout = function () {

    const customDropdown = function() {
        $('.selectBox').SumoSelect({
            search: true
        });
    }

    const checkoutTabs = function() {
        enquire.register("screen and (min-width:769px)", {
            match : function() {
                let navItems = document.querySelectorAll('.nav-item-anchor');
                let tabPanes = document.querySelectorAll('.tab-pane');
                document.querySelector('.tab-content').firstElementChild.classList.add('active');
                navItems.forEach(function(tabItem) {
                    tabItem.onclick = function(e) {
                        const hrefStr = this.getAttribute("data-href");
                        currentItem = hrefStr.substring(1);
                        if (currentItem) {
                            navItems.forEach(function(btn) {
                                btn.closest('.nav-item').classList.remove("active-tab");
                            });
                            tabPanes.forEach(function(pane) {
                                pane.classList.remove("active");
                            });
                            e.target.closest('.nav-item').classList.add("active-tab");
                            const currentPane = document.getElementById(currentItem);
                            currentPane.classList.add("active");
                        }
                        e.preventDefault()
                    }
                });
            }
        });


        enquire.register("screen and (max-width:768px)", {
            match : function() {
                let navItems = document.querySelectorAll('.nav-item-anchor');
                let tabPanes = document.querySelectorAll('.tab-pane');
                navItems.forEach(function(tabItem) {
                    tabItem.onclick = function(e) {
                        const hrefStr = this.getAttribute("data-href");
                        currentItem = hrefStr.substring(1);
                        if (currentItem) {
                            navItems.forEach(function(btn) {
                                btn.closest('.nav-item').classList.remove("active-tab");
                            });
                            tabPanes.forEach(function(pane) {
                                pane.classList.remove("active");
                            });
                            e.target.closest('.nav-item').classList.add("active-tab");
                            const currentPane = document.getElementById(currentItem);
                            currentPane.classList.add("active");
                        }
                        //document.querySelector('.mobile-header').classList.add('mobile-header-center');
                        document.querySelector('.nav-tabs').classList.remove('show');
                        document.querySelector('.nav-tabs').classList.add('hide');

                        e.preventDefault()
                    }
                });

                $('.back-btn').click(function(){
                    $('.tab-content .tab-pane').removeClass('active');
                    $('.nav-tabs').removeClass('hide').addClass('show');
                    //$('.mobile-header').removeClass('mobile-header-center');
                });

                $('.upi-logos a, .cash-card-logos a, .banking-logos a').click(function(e){
                    $('.upi-logos a, .cash-card-logos a, .banking-logos a').removeClass('active-logo');
                    $(this).addClass('active-logo');
                    e.preventDefault()
                });
            }
        });
    };

    return {
        init: function () {
            customDropdown();
            checkoutTabs();
        }
    };
}();

$(document).ready(function () {
    Checkout.init();
});
