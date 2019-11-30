<template>
    <div class="kt-header__topbar-item dropdown">
        <div
            class="kt-header__topbar-wrapper"
            data-toggle="dropdown"
            data-offset="30px,0px"
            aria-expanded="true"
        >
            <span class="kt-header__topbar-icon kt-pulse kt-pulse--brand">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="24px"
                    height="24px"
                    viewBox="0 0 24 24"
                    version="1.1"
                    class="kt-svg-icon"
                >
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                        <path
                            d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
                            id="Combined-Shape"
                            fill="#000000"
                            opacity="0.3"
                        ></path>
                        <path
                            d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
                            id="Combined-Shape"
                            fill="#000000"
                        ></path>
                    </g>
                </svg>
                <span class="kt-pulse__ring"></span>
            </span>
        </div>
        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-lg">
            <form>
                <div
                    class="kt-head kt-head--skin-dark kt-head--fit-x kt-head--fit-b"
                    :style="`background-image: url('${genericBG}');`"
                >
                    <h3 class="kt-head__title">
                        User Notifications
                        &nbsp;
                        <!-- <span class="btn btn-success btn-sm btn-bold btn-font-md">1 new</span> -->
                    </h3>
                    <ul
                        role="tablist"
                        class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-success kt-notification-item-padding-x"
                    >
                        <li class="nav-item">
                            <a
                                data-toggle="tab"
                                href="#topbar_notifications_notifications"
                                role="tab"
                                aria-selected="true"
                                class="nav-link active show"
                            >Alerts</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div
                        id="topbar_notifications_notifications"
                        role="tabpanel"
                        class="tab-pane active show"
                    >
                        <div class="kt-grid kt-grid--ver" style="min-height: 200px;">
                            <div class="kt-grid kt-grid--hor kt-grid__item kt-grid__item--fluid kt-grid__item--middle">
                                <div class="kt-grid__item kt-grid__item--middle kt-align-center">
                                    All caught up!
                                    <br>No new notifications.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import genericBG from '../../images/generic-bg1.jpg'

export default {
    name: 'HeaderNotificationsDropdown',
    data() {
        return {
            genericBG: genericBG
        }
    }
}
</script>
