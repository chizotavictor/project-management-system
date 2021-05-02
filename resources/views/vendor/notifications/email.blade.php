@extends('vendor.notifications.layouts.mail')
@section('content')
    <table style="width:100%;max-width:620px;margin:0 auto;background-color:#ffffff;">
        <tbody>
            <tr>
                <td style="padding: 30px 30px 15px 30px;">
                    <h2 style="color: #007bff; margin: 0; text-align: center;">
                        Confirm Your E-Mail Address
                    </h2>
                </td>
            </tr>
            <tr>
                <td style="padding: 0 30px 20px">
                    <p style="margin-bottom: 10px;">Hi!</p>
                    <p style="margin-bottom: 10px;">
                        You are receiving this email because you have registered on our site.
                        Click the link below to activate your <b>Gamint</b> account.
                    </p>
                    <p style="margin-bottom: 25px;">This link will expire in 15 minutes and can only be used once.</p>
                    <div style="text-align: center;">
                        <a href="{{ $actionUrl }}" style="background-color:#007bff;border-radius:4px;color:#ffffff;display:inline-block;line-height:44px;text-transform:uppercase;padding: 0 30px">Verify Email</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding: 0 30px">
                    <p style="margin-bottom: 10px;">If the button above does not work, paste this link into your web browser:</p>
                    <a href="#" style="color: #007bff; text-decoration:none;word-break: break-all;">{{ $actionUrl }} </a>
                </td>
            </tr>
            <tr>
                <td style="padding: 20px 30px 40px">
                    <p>If you did not create an account, no further action is required.</p>
                    <p style="margin: 0; font-size: 13px; line-height: 22px; color:#9ea8bb;">
                        This is an automatically generated email please do not reply to this email.
                        If you face any issues, please contact us at <a href="mailto:support@gamint.com">
                            support@gamint.com</a>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
@endsection()
