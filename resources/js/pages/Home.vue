<template>
    <div class="gq-wrapper">
        <!-- begin:: Header Mobile -->
		<HeaderMobile />

		<!-- end:: Header Mobile -->
		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

				<!-- begin:: Aside -->
				<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
				<Sidebar />

				<!-- end:: Aside -->
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

					<!-- begin:: Header -->
					<Header :key="header_key" />

					<!-- end:: Header -->
                    <transition name="fade" mode="out-in">
                        <router-view @reload_avatar="reload" :key="$router.fullPath"></router-view>
                    </transition>
					

					<!-- begin:: Footer -->
					<Footer />

					<!-- end:: Footer -->
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!-- begin::Quick Panel -->
		<QuickPanel />

		<!-- end::Quick Panel -->

		<!-- begin::Scrolltop -->
        <ScrollToTop />

		<!-- end::Scrolltop -->
    </div>
</template>

<script>
import HeaderMobile from '../includes/HeaderMobile'
import Header from '../includes/Header'
import Sidebar from '../includes/Sidebar'
import Footer from '../includes/Footer'
import QuickPanel from '../includes/QuickPanel'
import ScrollToTop from '../includes/ScrollToTop'


export default {
    name: "page-home",
    components: {
        HeaderMobile,
        Header,
        Sidebar,
        Footer,
        QuickPanel,
        ScrollToTop
    },
    data() {
        return {
            header_key: 0,
        }
    },
    mounted(){
    	this.reload
    },
    methods: {
        reload(){
                this.header_key += 1
            
        }
    }
};
</script>
