<!DOCTYPE html>
<html>
    <head>
        <title>
            Licensee
        </title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.2/vue.min.js">
        </script>
        <link href="//unpkg.com/bootstrap@next/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.css" rel="stylesheet" type="text/css"/>
        <script src="//unpkg.com/babel-polyfill@latest/dist/polyfill.min.js">
        </script>
        <script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.js">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.0/axios.min.js"></script>
    </head>
    <body>
        <div id="app">
            <template>
                <b-navbar toggleable="md" type="dark" variant="info">
                    <b-navbar-brand href="javascript:;">
                        Licensee
                    </b-navbar-brand>
                    <b-nav is-nav-bar class="ml-auto">
                        <b-nav-item @click="showModal()">Add Role</b-nav-item>
                    </b-nav>
                </b-navbar>
                <b-container fluid>
                    @yield('content')
                </b-container>
            </template>
        </div>
        @yield('javascript')
    </body>
</html>
