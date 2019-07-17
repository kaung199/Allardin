<template>
    <div>
        <Navigation></Navigation>
        <router-view></router-view>
        <Footer></Footer>
    </div>
</template>
<script>
import Navigation from './NavigationComponent'
import Footer from './FooterComponent'

export default {
    components: {
        Navigation,
        Footer
    }
    
}
</script>