<template>
    <div class="notification">
        <b-dropdown toggle-class="text-decoration-none" no-caret variant="link">
            <template #button-content>
                <span>
                    <i class="fal fa-bell"></i>
                    <span class="badge badge-pill badge-primary badge-up">5</span>
                </span>
            </template>
            <b-dropdown-text class="header">
                Có 5 thông báo mới
            </b-dropdown-text>
            <b-dropdown-item class="item">
                <div class="order" style="float: left; padding: 5px">
                    <i class="fal fa-box"></i>
                </div>
                <div class="px-2">
                    <span class="title order">
                        New order recieved
                    </span><br>
                    <small>You got new order of god</small>
                </div>
                <small>
                    <time datetime="2015-06-11T18:29:20+08:00">9 hours ago</time>
                </small>
            </b-dropdown-item>
            <b-dropdown-item class="item">
                <div class="order" style="float: left; padding: 5px">
                    <i class="fal fa-box"></i>
                </div>
                <div class="px-2">
                    <span class="title order">
                        New order recieved
                    </span><br>
                    <small>You got new order of god</small>
                </div>
                <small>
                    <time datetime="2015-06-11T18:29:20+08:00">9 hours ago</time>
                </small>
            </b-dropdown-item>
            <b-dropdown-item class="item">
                <div class="order" style="float: left; padding: 5px">
                    <i class="fal fa-box"></i>
                </div>
                <div class="px-2">
                    <span class="title order">
                        New order recieved
                    </span><br>
                    <small>You got new order of god</small>
                </div>
                <small>
                    <time datetime="2015-06-11T18:29:20+08:00">9 hours ago</time>
                </small>
            </b-dropdown-item>
            <b-dropdown-item class="item">
                <div class="order" style="float: left; padding: 5px">
                    <i class="fal fa-box"></i>
                </div>
                <div class="px-2">
                    <span class="title order">
                        New order recieved
                    </span><br>
                    <small>You got new order of god</small>
                </div>
                <small>
                    <time datetime="2015-06-11T18:29:20+08:00">9 hours ago</time>
                </small>
            </b-dropdown-item>
        </b-dropdown>
    </div>
</template>
<style lang="scss">
.notification {
    position: relative;
    i {
        font-size: 21px;
    }
    .badge {
        position: absolute;
        right: 5px;
        top: 5px;
    }
    .item {
        border-bottom: 1px solid #DAE1E7;
        i {
            margin-right: 0.75rem !important;
            font-size: 18px !important;
        }
        .title {
            font-weight: 500;
        }
        .order {
                color: #28c76f
        }
    }
    .header {
        width: 330px;
        text-align: center;
        height: 40px;
        line-height: 40px;
        color: #fff;
        background-color: #7367F0;
    }
}
</style>