@extends('vendor.notifications.layouts.mail')
@section('content')
    <table style="width:100%;max-width:620px;margin:0 auto;background-color:#ffffff;">
        <tbody>
        <tr>
            <td style="padding: 30px 30px 15px 30px;">
                <h2 style="color: #007bff; margin: 0; text-align: center">
                    Task Issue Resolved
                </h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 0 30px 20px">
                <h3 style="margin-bottom: 10px;">Hi! {{ $fullName }}</h3>
                <p style="margin-bottom: 10px;">
                    The issue on the task titled <b>{{ $taskTitle }}</b> has been resolved.
                    Kindly visit your dashboard to see if this issue has been attended to
                </p>
                <div style="text-align: center;">
                    <a href="{{ route('login')}}" style="background-color:#007bff;border-radius:4px;color:#ffffff;display:inline-block;line-height:44px;text-transform:uppercase;padding: 0 30px">
                        Login
                    </a>
                </div>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px 30px 40px">
                <p style="margin: 0; font-size: 13px; line-height: 22px; color:#9ea8bb;">
                    This is an automatically generated email please do not reply to this email.
                    If you face any issues, please contact us at <a href="mailto:support@gamint.com">support@gamint.com</a>
                </p>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
