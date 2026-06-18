<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
</head>

<body style="margin:0;padding:0;background-color:#f1f5f9;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0"
        style="background-color:#f1f5f9;padding:40px 15px;">

        <tr>
            <td align="center">

                <!-- Email Card -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="max-width:650px;background:#ffffff;border-radius:24px;overflow:hidden;border:1px solid #e2e8f0;">

                    <!-- Header -->
                    <tr>
                        <td align="center"
                            style="background:#0f172a;padding:50px 35px;">

                            <!-- Logo -->
                            {{-- <div style="
                                width:80px;
                                height:80px;
                                line-height:80px;
                                border-radius:50%;
                                background:#14b8a6;
                                color:#ffffff;
                                font-size:32px;
                                font-weight:700;
                                text-align:center;
                                margin:0 auto 25px auto;">
                                {{ substr(config('app.name'), 0, 1) }}
                            </div> --}}

                            <h1 style="
                                margin:0;
                                color:#ffffff;
                                font-size:32px;
                                font-weight:700;
                                letter-spacing:1px;">
                                Dhruv
                            </h1>

                            <p style="
                                margin:12px 0 0;
                                color:#94a3b8;
                                font-size:15px;
                                letter-spacing:2px;
                                text-transform:uppercase;">
                                Event Management System
                            </p>

                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:50px 40px;">

                            {{-- <div style="height:35px;"></div> --}}

                            <!-- Information Box -->
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="
                                background:#f8fafc;
                                border:1px solid #e2e8f0;
                                border-radius:14px;">

                                <tr>
                                    <td style="padding:25px;">
                                        @yield('content')
                                    </td>
                                </tr>

                            </table>

                            {{-- <div style="height:35px;"></div> --}}

                        </td>
                    </tr>

                    <!-- Divider -->
                    <tr>
                        <td style="padding:0 40px;">
                            <hr style="
                                border:none;
                                border-top:1px solid #e2e8f0;
                                margin:0;">
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="
                            background:#ffffff;
                            padding:35px;">

                            <p style="
                                margin:0;
                                color:#1e293b;
                                font-size:15px;
                                font-weight:600;">
                                Thank you for choosing
                                <span style="color:#14b8a6;">
                                    {{ $event->event_name }}
                                </span>
                            </p>

                            <p style="
                                margin:18px 0 0;
                                color:#64748b;
                                font-size:13px;
                                line-height:24px;">
                                This is an automated email notification.<br>
                                Please do not reply to this email.
                            </p>

                            <p style="
                                margin:20px 0 0;
                                color:#94a3b8;
                                font-size:12px;">
                                © {{ date('Y') }}
                                {{ config('app.name') }}.
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