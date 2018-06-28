Hello {{$user->name}}
Please verify your new email:{{route('verify',[$user->verification_token])}}