<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @import url(https://fonts.googleapis.com/css?family=Nunito);

        :root{
            --blue:#3490dc;
            --indigo:#6574cd;
            --purple:#9561e2;
            --pink:#f66d9b;
            --red:#e3342f;
            --orange:#f6993f;
            --yellow:#ffed4a;
            --green:#38c172;
            --teal:#4dc0b5;
            --cyan:#6cb2eb;
            --white:#fff;
            --gray:#6c757d;
            --gray-dark:#343a40;
            --primary:#3490dc;
            --secondary:#6c757d;
            --success:#38c172;
            --info:#6cb2eb;
            --warning:#ffed4a;
            --danger:#e3342f;
            --light:#f8f9fa;
            --dark:#343a40;
            --breakpoint-xs:0;
            --breakpoint-sm:576px;
            --breakpoint-md:768px;
            --breakpoint-lg:992px;
            --breakpoint-xl:1200px;
            --font-family-sans-serif:"Nunito",sans-serif;
            --font-family-monospace:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace
        }
        *,:after,:before{
            box-sizing:border-box
        }
        html{
            font-family:sans-serif;
            line-height:1.15;
            -webkit-text-size-adjust:100%;
            -webkit-tap-highlight-color:rgba(0,0,0,0)
        }
        article,aside,figcaption,figure,footer,header,hgroup,main,nav,section{
            display:block
        }
        body{
            margin:0;
            font-family:Nunito,sans-serif;
            font-size:.9rem;
            font-weight:400;
            line-height:1.6;
            color:#212529;
            text-align:left;
            background-color:#f8fafc
        }
        [tabindex="-1"]:focus:not(:focus-visible){
            outline:0!important
        }
        hr{
            box-sizing:content-box;
            height:0;
            overflow:visible
        }
        h1,h2,h3,h4,h5,h6{
            margin-top:0;
            margin-bottom:.5rem
        }
        p{
            margin-top:0;
            margin-bottom:1rem
        }
        abbr[data-original-title],abbr[title]{
            text-decoration:underline;
            -webkit-text-decoration:underline dotted;
            text-decoration:underline dotted;
            cursor:help;
            border-bottom:0;
            -webkit-text-decoration-skip-ink:none;
            text-decoration-skip-ink:none
        }
        address{
            font-style:normal;
            line-height:inherit
        }
        address,dl,ol,ul{
            margin-bottom:1rem
        }
        dl,ol,ul{
            margin-top:0
        }
        ol ol,ol ul,ul ol,ul ul{
            margin-bottom:0
        }
        dt{
            font-weight:700
        }
        dd{
            margin-bottom:.5rem;
            margin-left:0
        }
        blockquote{
            margin:0 0 1rem
        }
        b,strong{
            font-weight:bolder
        }
        small{
            font-size:80%
        }
        sub,sup{
            position:relative;
            font-size:75%;
            line-height:0;
            vertical-align:baseline
        }
        sub{
            bottom:-.25em
        }
        sup{
            top:-.5em
        }
        a{
            color:#3490dc;
            text-decoration:none;
            background-color:transparent
        }
        a:hover{
            color:#1d68a7;
            text-decoration:underline
        }
        a:not([href]),a:not([href]):hover{
            color:inherit;
            text-decoration:none
        }
        code,kbd,pre,samp{
            font-family:SFMono-Regular,Menlo,Monaco,Consolas,Liberation Mono,Courier New,monospace;
            font-size:1em
        }
        pre{
            margin-top:0;
            margin-bottom:1rem;
            overflow:auto;
            -ms-overflow-style:scrollbar
        }
        figure{
            margin:0 0 1rem
        }
        img{
            border-style:none
        }
        img,svg{
            vertical-align:middle
        }
        svg{
            overflow:hidden
        }
        table{
            border-collapse:collapse
        }
        caption{
            padding-top:.75rem;
            padding-bottom:.75rem;
            color:#6c757d;
            text-align:left;
            caption-side:bottom
        }
        th{
            text-align:inherit
        }
        label{
            display:inline-block;
            margin-bottom:.5rem
        }

        @media (min-width:1200px){
            .col-xl{
                flex-basis:0;
                flex-grow:1;
                min-width:0;
                max-width:100%
            }
            .row-cols-xl-1>*{
                flex:0 0 100%;
                max-width:100%
            }
            .row-cols-xl-2>*{
                flex:0 0 50%;
                max-width:50%
            }
            .row-cols-xl-3>*{
                flex:0 0 33.3333333333%;
                max-width:33.3333333333%
            }
            .row-cols-xl-4>*{
                flex:0 0 25%;
                max-width:25%
            }
            .row-cols-xl-5>*{
                flex:0 0 20%;
                max-width:20%
            }
            .row-cols-xl-6>*{
                flex:0 0 16.6666666667%;
                max-width:16.6666666667%
            }
            .col-xl-auto{
                flex:0 0 auto;
                width:auto;
                max-width:100%
            }
            .col-xl-1{
                flex:0 0 8.3333333333%;
                max-width:8.3333333333%
            }
            .col-xl-2{
                flex:0 0 16.6666666667%;
                max-width:16.6666666667%
            }
            .col-xl-3{
                flex:0 0 25%;
                max-width:25%
            }
            .col-xl-4{
                flex:0 0 33.3333333333%;
                max-width:33.3333333333%
            }
            .col-xl-5{
                flex:0 0 41.6666666667%;
                max-width:41.6666666667%
            }
            .col-xl-6{
                flex:0 0 50%;
                max-width:50%
            }
            .col-xl-7{
                flex:0 0 58.3333333333%;
                max-width:58.3333333333%
            }
            .col-xl-8{
                flex:0 0 66.6666666667%;
                max-width:66.6666666667%
            }
            .col-xl-9{
                flex:0 0 75%;
                max-width:75%
            }
            .col-xl-10{
                flex:0 0 83.3333333333%;
                max-width:83.3333333333%
            }
            .col-xl-11{
                flex:0 0 91.6666666667%;
                max-width:91.6666666667%
            }
            .col-xl-12{
                flex:0 0 100%;
                max-width:100%
            }
            .order-xl-first{
                order:-1
            }
            .order-xl-last{
                order:13
            }
            .order-xl-0{
                order:0
            }
            .order-xl-1{
                order:1
            }
            .order-xl-2{
                order:2
            }
            .order-xl-3{
                order:3
            }
            .order-xl-4{
                order:4
            }
            .order-xl-5{
                order:5
            }
            .order-xl-6{
                order:6
            }
            .order-xl-7{
                order:7
            }
            .order-xl-8{
                order:8
            }
            .order-xl-9{
                order:9
            }
            .order-xl-10{
                order:10
            }
            .order-xl-11{
                order:11
            }
            .order-xl-12{
                order:12
            }
            .offset-xl-0{
                margin-left:0
            }
            .offset-xl-1{
                margin-left:8.3333333333%
            }
            .offset-xl-2{
                margin-left:16.6666666667%
            }
            .offset-xl-3{
                margin-left:25%
            }
            .offset-xl-4{
                margin-left:33.3333333333%
            }
            .offset-xl-5{
                margin-left:41.6666666667%
            }
            .offset-xl-6{
                margin-left:50%
            }
            .offset-xl-7{
                margin-left:58.3333333333%
            }
            .offset-xl-8{
                margin-left:66.6666666667%
            }
            .offset-xl-9{
                margin-left:75%
            }
            .offset-xl-10{
                margin-left:83.3333333333%
            }
            .offset-xl-11{
                margin-left:91.6666666667%
            }
        }
        .table{
            width:100%;
            margin-bottom:1rem;
            color:#212529
        }
        .table td,.table th{
            padding:.75rem;
            vertical-align:top;
            border-top:1px solid #dee2e6
        }
        .table thead th{
            vertical-align:bottom;
            border-bottom:2px solid #dee2e6
        }
        .table tbody+tbody{
            border-top:2px solid #dee2e6
        }
        .table-sm td,.table-sm th{
            padding:.3rem
        }
        .table-bordered,.table-bordered td,.table-bordered th{
            border:1px solid #dee2e6
        }
        .table-bordered thead td,.table-bordered thead th{
            border-bottom-width:2px
        }
        .table-borderless tbody+tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{
            border:0
        }
        .table-striped tbody tr:nth-of-type(odd){
            background-color:rgba(0,0,0,.05)
        }
        .table-hover tbody tr:hover{
            color:#212529;
            background-color:rgba(0,0,0,.075)
        }
        .table-primary,.table-primary>td,.table-primary>th{
            background-color:#c6e0f5
        }
        .table-primary tbody+tbody,.table-primary td,.table-primary th,.table-primary thead th{
            border-color:#95c5ed
        }
        .table-hover .table-primary:hover,.table-hover .table-primary:hover>td,.table-hover .table-primary:hover>th{
            background-color:#b0d4f1
        }
        .table-secondary,.table-secondary>td,.table-secondary>th{
            background-color:#d6d8db
        }
        .table-secondary tbody+tbody,.table-secondary td,.table-secondary th,.table-secondary thead th{
            border-color:#b3b7bb
        }
        .table-hover .table-secondary:hover,.table-hover .table-secondary:hover>td,.table-hover .table-secondary:hover>th{
            background-color:#c8cbcf
        }
        .table-success,.table-success>td,.table-success>th{
            background-color:#c7eed8
        }
        .table-success tbody+tbody,.table-success td,.table-success th,.table-success thead th{
            border-color:#98dfb6
        }
        .table-hover .table-success:hover,.table-hover .table-success:hover>td,.table-hover .table-success:hover>th{
            background-color:#b3e8ca
        }
        .table-info,.table-info>td,.table-info>th{
            background-color:#d6e9f9
        }
        .table-info tbody+tbody,.table-info td,.table-info th,.table-info thead th{
            border-color:#b3d7f5
        }
        .table-hover .table-info:hover,.table-hover .table-info:hover>td,.table-hover .table-info:hover>th{
            background-color:#c0ddf6
        }
        .table-warning,.table-warning>td,.table-warning>th{
            background-color:#fffacc
        }
        .table-warning tbody+tbody,.table-warning td,.table-warning th,.table-warning thead th{
            border-color:#fff6a1
        }
        .table-hover .table-warning:hover,.table-hover .table-warning:hover>td,.table-hover .table-warning:hover>th{
            background-color:#fff8b3
        }
        .table-danger,.table-danger>td,.table-danger>th{
            background-color:#f7c6c5
        }
        .table-danger tbody+tbody,.table-danger td,.table-danger th,.table-danger thead th{
            border-color:#f09593
        }
        .table-hover .table-danger:hover,.table-hover .table-danger:hover>td,.table-hover .table-danger:hover>th{
            background-color:#f4b0af
        }
        .table-light,.table-light>td,.table-light>th{
            background-color:#fdfdfe
        }
        .table-light tbody+tbody,.table-light td,.table-light th,.table-light thead th{
            border-color:#fbfcfc
        }
        .table-hover .table-light:hover,.table-hover .table-light:hover>td,.table-hover .table-light:hover>th{
            background-color:#ececf6
        }
        .table-dark,.table-dark>td,.table-dark>th{
            background-color:#c6c8ca
        }
        .table-dark tbody+tbody,.table-dark td,.table-dark th,.table-dark thead th{
            border-color:#95999c
        }
        .table-hover .table-dark:hover,.table-hover .table-dark:hover>td,.table-hover .table-dark:hover>th{
            background-color:#b9bbbe
        }
        .table-active,.table-active>td,.table-active>th,.table-hover .table-active:hover,.table-hover .table-active:hover>td,.table-hover .table-active:hover>th{
            background-color:rgba(0,0,0,.075)
        }
        .table .thead-dark th{
            color:#fff;
            background-color:#343a40;
            border-color:#454d55
        }
        .table .thead-light th{
            color:#495057;
            background-color:#e9ecef;
            border-color:#dee2e6
        }
        .table-dark{
            color:#fff;
            background-color:#343a40
        }
        .table-dark td,.table-dark th,.table-dark thead th{
            border-color:#454d55
        }
        .table-dark.table-bordered{
            border:0
        }
        .table-dark.table-striped tbody tr:nth-of-type(odd){
            background-color:hsla(0,0%,100%,.05)
        }
        .table-dark.table-hover tbody tr:hover{
            color:#fff;
            background-color:hsla(0,0%,100%,.075)
        }


    </style>
</head>
@yield('report-content')
</html>
