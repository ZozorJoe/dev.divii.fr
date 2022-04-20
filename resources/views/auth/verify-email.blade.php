<x-app-layout>
    <!--begin::Authentication - Signup Verify Email -->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div class="bg-grad-4"></div>
        <div class="d-flex flex-column flex-column-fluid text-center p-10 py-lg-15">
            <!--begin::Logo-->
            <a href="/" class="mb-10 pt-lg-10">
                <img alt="Logo divii" src="/img/logo-dark.svg" class="h-80px mb-5" />
            </a>
            <!--end::Logo-->
            <!--begin::Wrapper-->
            <div class="pt-lg-10 mb-10">
                <!--begin::Logo-->
                <h1 class="canela-thin-italic tarifs-title fw-normal mb-7">Vérifiez votre email</h1>
                <!--end::Logo-->

                @if (session()->has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session()->get('error') }}
                    </div>
                @endif

                @if (session()->has('success'))
                    <div class="mb-10">
                        <!--begin::Message-->
                        <div class="fs-3 fw-bold ">Nous avons envoyé un email à
                            <a href="mailto:{{ $model->email }}" class="link-primary fw-bolder">{{ $model->email }}</a>
                            <br>Veuillez suivre un lien pour vérifier votre adresse email.
                        </div>
                        <!--end::Message-->
                    </div>
                @endif

                <!-- begin::Action -->
                <div class="fw-bold fs-3 mb-10">
                    Avant de continuer, veuillez vérifier votre email pour un lien de vérification.
                    <br>Si vous n'avez pas reçu l'email,
                    <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">cliquez ici pour en demander un autre</button>.
                    </form>
                </div>
                <!-- end::Action -->

                <!-- begin::Action -->
                <div class="text-center mb-10">
                    <a href="/auth/logout" class="btn btn-lg fiche-btn bg-yellow">Se déconnecter</a>
                </div>
                <!-- end::Action -->
            </div>
            <!-- end::Wrapper -->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Authentication - Signup Verify Email-->
</x-app-layout>
