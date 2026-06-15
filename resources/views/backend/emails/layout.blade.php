<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
</head>

<body style="
    margin:0;
    padding:0;
    background:#f4f7fc;
    font-family:Arial, Helvetica, sans-serif;
    color:#374151;
">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding:40px 15px;background:#f4f7fc;">

        <tr>
            <td align="center">

                <table width="650" cellpadding="0" cellspacing="0" border="0" style="
                    background:#ffffff;
                    border-radius:20px;
                    overflow:hidden;
                    box-shadow:0 10px 35px rgba(0,0,0,0.08);
                ">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="
                            background:linear-gradient(135deg,#6366f1,#818cf8);
                            padding:40px;
                        ">

                            <!-- Logo -->
                            <img src="{{ url('images/logo.png') }}" width="75" alt="{{ config('app.name') }}" style="
                                display:block;
                                margin:auto;
                                margin-bottom:20px;
                                background:#fff;
                                padding:15px;
                                border-radius:20px;
                            ">

                            <h1 style="
                            margin:0;
                            color:#ffffff;
                            font-size:30px;
                            font-weight:700;
                        ">
                                {{ config('app.name') }}
                            </h1>

                            <p style="
                            margin-top:10px;
                            color:#eef2ff;
                            font-size:15px;
                        ">
                                Event Management System
                            </p>

                        </td>
                    </tr>

                    <!-- Dynamic Content -->
                    <tr>
                        <td style="
                        padding:45px;
                        font-size:15px;
                        line-height:1.8;
                    ">
                            @yield('content')
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="
                        background:#fafbfc;
                        border-top:1px solid #e5e7eb;
                        padding:30px;
                        text-align:center;
                    ">

                            <p style="
                            margin:0;
                            color:#6b7280;
                            font-size:14px;
                        ">
                                Thank you for using
                                <strong style="color:#4f46e5;">
                                    {{ config('app.name') }}
                                </strong>
                            </p>

                            <p style="
                            margin-top:12px;
                            color:#9ca3af;
                            font-size:13px;
                        ">
                                © {{ date('Y') }}
                                {{ config('app.name') }}
                                <br>
                                All Rights Reserved.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>

    </table>

</body>

</html>