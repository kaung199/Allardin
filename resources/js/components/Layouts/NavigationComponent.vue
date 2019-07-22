<template>
    <div>
        <!-- <div class="navagation">
            <div class="nav">
                <router-link to="/">Aladdin Online Shop</router-link>            
            </div>  
        </div> -->
        <div class="navagation">
            <b-navbar toggleable="lg" type="dark" variant="info" fixed="top">                
                <b-navbar-brand><router-link to="/">Aladdin Online Shop</router-link></b-navbar-brand>
                <b-navbar-nav class="marginleft">
                        <b-nav-item><router-link to="/">Home</router-link></b-nav-item>
                        <b-nav-item-dropdown text="Categories" right>
                            <b-dropdown-item><router-link to="detail">Category1</router-link></b-dropdown-item>
                            <b-dropdown-item><router-link to="page1">Category2</router-link></b-dropdown-item>
                            <b-dropdown-item><router-link to="page2">Category3</router-link></b-dropdown-item>
                            <b-dropdown-item><router-link to="page3">Category4</router-link></b-dropdown-item>
                        </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-navbar>
        </div>
    </div>
</template>
