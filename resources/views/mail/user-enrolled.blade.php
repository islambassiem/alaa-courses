<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Confirmation</title>

    <style>
        /* Mobile styles */
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
            }

            .px {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }

            .py {
                padding-top: 20px !important;
                padding-bottom: 20px !important;
            }

            .text-center {
                text-align: center !important;
            }

            .button {
                display: block !important;
                width: 90% !important;
            }
        }
    </style>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f8;">

    <table width="90%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:20px 0; margin-left: auto; margin-right: auto;">
        <tr>
            <td align="center">

                <!-- Container -->
                <table class="container" width="600" cellpadding="0" cellspacing="0"
                    style="width:600px; max-width:600px; background:#ffffff; border-radius:8px; overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background:#4f46e5; padding:20px; text-align:center; color:#ffffff;">
                            <h1 style="margin:0; font-size:20px;">{{ config('app.name') }}</h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td class="px py" style="padding:30px; font-family:Arial, sans-serif; color:#333;">

                            <h2 style="margin-top:0;">You're enrolled 🎉</h2>

                            <p>Hi {{ $user->name }},</p>

                            <p>
                                You've successfully enrolled in the course:
                            </p>

                            <!-- Course box -->
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="background:#f9fafb; border-radius:6px; margin:20px 0;">
                                <tr>
                                    <td style="padding:15px;">
                                        <strong>{{ $course->title }}</strong><br>
                                        <span style="color:#6b7280;">
                                            {{ $course->subtitle ?? '' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <p>You can now start learning right away.</p>

                            <!-- Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="text-center" style="padding:20px 10px;">
                                        <a href="{{ route('courses.show', $course) }}" class="button"
                                            style="background:#4f46e5; color:#ffffff; padding:12px 24px; text-decoration:none; border-radius:6px; display:inline-block;">
                                            Go to Course →
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="color:#6b7280; font-size:14px;">
                                If you have any questions, just reply to this email.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f9fafb; padding:20px; text-align:center; font-size:12px; color:#9ca3af;">
                            © {{ date('Y') }} {{ config('app.name') }}
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
