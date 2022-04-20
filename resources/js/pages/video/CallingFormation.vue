<template>
  <div class="modal-content rounded">

    <!--begin::Modal header-->
    <div v-if="offline" class="modal-header border-0 pt-1 pb-1 mb-1">
      <div></div>

      <div class="d-flex flex-center">
        <!--begin::Chat Button -->
        <ChatDrawerButton />
        <!--end::Chat Button -->
      </div>
    </div>
    <!--end::Modal header-->

    <!--begin::Modal-->
    <div v-if="offline" class="modal-body pt-0 pb-15 px-5 px-xl-20 d-flex flex-center flex-column">
        <div v-if="model" class="d-flex flex-center flex-column p-9">
          <!--begin::Wrapper-->
          <div v-if="model.user" class="mb-5">
            <!--begin::Avatar-->
            <div class="symbol symbol-75px symbol-circle">
              <img alt="Pic" :src="`/u/image-${model.user.id}.jpg`">
            </div>
            <!--end::Avatar-->
          </div>
          <!--end::Wrapper-->

          <!--begin::Name-->
          <a v-if="model.user" href="#" class="fs-4 text-gray-800 text-hover-primary fw-bolder mb-0">{{ model.user.name }}</a>
          <!--end::Name-->

          <!--begin::Position-->
          <div v-if="model.user && model.user.disciplines && model.user.disciplines.length" class="fw-bold text-gray-400 mb-6">{{ model.user.disciplines[0].name }}</div>
          <!--end::Position-->

          <!--begin::Heading-->
          <div class="text-center mb-13">
            <!--begin::Title-->
            <h1 class="mb-3">{{ model.title }}</h1>
            <!--end::Title-->
            <CountDown v-model="duration" :duration="duration" />
          </div>
          <!--end::Heading-->

          <!--begin::Link-->
          <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a href="/auth/login" class="btn btn-flex btn-light btn-active-primary fw-bolder">
              Retours
            </a>
            <button v-if="duration > 0 " @click="start" class="btn btn-success ml-2">
              Rejoindre
            </button>
          </div>
          <!--end::Link-->

        </div>
    </div>
    <!--end::Modal-->

    <!--begin::Modal header-->
    <div v-if="!offline" class="modal-header border-0 pt-1 pb-1 mb-1" id="kt_room_header">

      <div class="border border-gray-300 border-dashed rounded px-1 me-1">
        <CountDown v-if="duration > 0" v-model="duration" :duration="duration" />
      </div>

      <div class="d-flex flex-center">

        <!--begin::Chat Button -->
        <ChatDrawerButton />
        <!--end::Chat Button -->

        <!--begin::Separator-->
        <span class="h-20px border-gray-200 border-start mx-4"></span>
        <!--end::Separator-->

        <button @click="localSwitches['video'] = !localSwitches['video']" :class="{'btn-info': localSwitches['video'], 'btn-default border-active': !localSwitches['video']}" class="btn btn-icon btn-rounded mx-2 w-40px h-40px" style="border-radius: 50%">
          <!--begin::Svg Icon-->
          <span v-if="localSwitches['video']" class="svg-icon svg-icon-dark svg-icon-2x">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-video" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M0 5a2 2 0 0 1 2-2h7.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 4.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 13H2a2 2 0 0 1-2-2V5zm11.5 5.175 3.5 1.556V4.269l-3.5 1.556v4.35zM2 4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h7.5a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H2z"/>
          </svg>
        </span>
          <span v-else class="svg-icon svg-icon-danger svg-icon-2x">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-video-off" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M10.961 12.365a1.99 1.99 0 0 0 .522-1.103l3.11 1.382A1 1 0 0 0 16 11.731V4.269a1 1 0 0 0-1.406-.913l-3.111 1.382A2 2 0 0 0 9.5 3H4.272l.714 1H9.5a1 1 0 0 1 1 1v6a1 1 0 0 1-.144.518l.605.847zM1.428 4.18A.999.999 0 0 0 1 5v6a1 1 0 0 0 1 1h5.014l.714 1H2a2 2 0 0 1-2-2V5c0-.675.334-1.272.847-1.634l.58.814zM15 11.73l-3.5-1.555v-4.35L15 4.269v7.462zm-4.407 3.56-10-14 .814-.58 10 14-.814.58z"/>
            </svg>
          </span>
          <!--end::Svg Icon-->
        </button>

        <button @click="localSwitches['audio'] = !localSwitches['audio']" :class="{'btn-info': localSwitches['audio'], 'btn-default border-active': !localSwitches['audio']}" class="btn btn-icon btn-rounded mx-2 w-40px h-40px" style="border-radius: 50%">
          <!--begin::Svg Icon-->
          <span v-if="localSwitches['audio']" class="svg-icon svg-icon-dark svg-icon-2x">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mic" viewBox="0 0 16 16">
              <path d="M3.5 6.5A.5.5 0 0 1 4 7v1a4 4 0 0 0 8 0V7a.5.5 0 0 1 1 0v1a5 5 0 0 1-4.5 4.975V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 .5-.5z"/>
              <path d="M10 8a2 2 0 1 1-4 0V3a2 2 0 1 1 4 0v5zM8 0a3 3 0 0 0-3 3v5a3 3 0 0 0 6 0V3a3 3 0 0 0-3-3z"/>
            </svg>
          </span>
          <span v-else class="svg-icon svg-icon-danger svg-icon-2x">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mic-mute" viewBox="0 0 16 16">
              <path d="M13 8c0 .564-.094 1.107-.266 1.613l-.814-.814A4.02 4.02 0 0 0 12 8V7a.5.5 0 0 1 1 0v1zm-5 4c.818 0 1.578-.245 2.212-.667l.718.719a4.973 4.973 0 0 1-2.43.923V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 1 0v1a4 4 0 0 0 4 4zm3-9v4.879l-1-1V3a2 2 0 0 0-3.997-.118l-.845-.845A3.001 3.001 0 0 1 11 3z"/>
              <path d="m9.486 10.607-.748-.748A2 2 0 0 1 6 8v-.878l-1-1V8a3 3 0 0 0 4.486 2.607zm-7.84-9.253 12 12 .708-.708-12-12-.708.708z"/>
              </svg>
          </span>
          <!--end::Svg Icon-->
        </button>

        <button @click="localSwitches['display'] = !localSwitches['display']" :class="{'btn-info': localSwitches['display'], 'btn-default border-active': !localSwitches['display']}" class="btn btn-icon btn-rounded mx-2 w-40px h-40px" style="border-radius: 50%">
          <!--begin::Svg Icon | path: assets/media/icons/duotune/electronics/elc004.svg-->
          <span class="svg-icon svg-icon-dark svg-icon-2x">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M2 16C2 16.6 2.4 17 3 17H21C21.6 17 22 16.6 22 16V15H2V16Z" fill="black"/>
              <path opacity="0.3" d="M21 3H3C2.4 3 2 3.4 2 4V15H22V4C22 3.4 21.6 3 21 3Z" fill="black"/>
              <path opacity="0.3" d="M15 17H9V20H15V17Z" fill="black"/>
            </svg>
          </span>
          <!--end::Svg Icon-->
        </button>

        <!--begin::Separator-->
        <span class="h-20px border-gray-200 border-start mx-4"></span>
        <!--end::Separator-->

        <button @click="stop" class="btn btn-sm btn-danger ml-2">
          Terminer
        </button>

      </div>

    </div>
    <!--end::Modal header-->

    <!--begin::Modal body-->
    <div v-if="!offline" class="modal-body py-0" id="kt_room_body">

      <!--begin::Layout-->
      <div class="d-flex flex-column flex-lg-row h-100">
        <!--begin::Content-->
        <div v-if="model && user" class="flex-lg-row-fluid ms-lg-7 ms-xl-10 h-100">
          <div v-if="model.user_id !== user.id" class="d-flex flex-center w-100 h-100 bg-black">
            <video
              v-if="mainRemoteStream"
              v-show="hasRemoteVideo(model.user_id)"
              :srcObject.prop="mainRemoteStream"
              muted
              autoplay
              playsinline
              class="h-100 mw-100">
              Your browser does not support the video tag.
            </video>
            <div v-if="!mainRemoteStream || !hasRemoteVideo(model.user_id)">
              En attente de l'expert
            </div>
          </div>
          <div v-else class="d-flex flex-center w-100 h-100 bg-black">
            <div v-if="localStreams['video'] || localStreams['display']" class="h-100 mw-100">
              <video
                ref="video"
                :srcObject.prop="localStreams['video'] ? localStreams['video'] : localStreams['display']"
                muted
                playsinline
                autoplay
                class="h-100 mw-100">
                Your browser does not support the video tag.
              </video>
              <canvas hidden ref="canvas"></canvas>
            </div>
            <div v-else>
              Veuillez commencer à partager vos écrans ou votre caméra!
            </div>
          </div>
        </div>
        <!--end::Content-->
        <!--begin::Sidebar-->
        <div class="flex-column flex-lg-row-auto w-100 w-lg-100px w-xl-150px w-xxl-300px mb-10 mb-lg-0 ps-2">
          <div class="scroll-y me-n5 pe-5"
               data-kt-scroll="true"
               data-kt-scroll-height="auto"
               data-kt-scroll-activate="{default: false, lg: true}"
               data-kt-scroll-max-height="auto"
               data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_room_header, #room_local_stream"
               data-kt-scroll-wrappers="#kt_content, #room_remote_streams"
               data-kt-scroll-offset="120px">
            <div class="row" id="room_remote_streams">
              <template
                v-if="user"
                v-for="item in users"
                :key="item.id"
              >
                <div
                  v-if="item.id !== user.id"
                  class="col-6 mx-0 px-1">
                  <div class="d-flex flex-wrap flex-center video-item overflow-hidden">
                    <div class="d-flex flex-center w-100 h-100">
                      <video
                        v-if="remoteStreams[item.id]"
                        v-show="hasRemoteVideo(item.id)"
                        :srcObject.prop="remoteStreams[item.id]"
                        :id="`remote-stream-${item.id}`"
                        autoplay
                        playsinline
                        class="w-100">
                        Your browser does not support the video tag.
                      </video>
                      <img
                        v-if="!remoteStreams[item.id] || !hasRemoteVideo(item.id)"
                        alt="Pic"
                        class="w-100"
                        src="/img/avatar.png"
                        style="max-height: 100%;">
                    </div>
                    <div class="d-flex flex-center flex-row w-100" style="margin-top: -25px;">
                      <button v-if="isExpert" @click="toggleMic(item.id)" class="btn btn-icon h-auto" style="border-radius: 50%">
                        <!--begin::Svg Icon-->
                        <span v-if="remoteSwitches[item.id] && remoteSwitches[item.id]['audio']" class="svg-icon" style="color: green;">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mic" viewBox="0 0 16 16">
                            <path d="M3.5 6.5A.5.5 0 0 1 4 7v1a4 4 0 0 0 8 0V7a.5.5 0 0 1 1 0v1a5 5 0 0 1-4.5 4.975V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 .5-.5z"/>
                            <path d="M10 8a2 2 0 1 1-4 0V3a2 2 0 1 1 4 0v5zM8 0a3 3 0 0 0-3 3v5a3 3 0 0 0 6 0V3a3 3 0 0 0-3-3z"/>
                          </svg>
                        </span>
                        <span v-else class="svg-icon" style="color: red;">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mic-mute" viewBox="0 0 16 16">
                            <path d="M13 8c0 .564-.094 1.107-.266 1.613l-.814-.814A4.02 4.02 0 0 0 12 8V7a.5.5 0 0 1 1 0v1zm-5 4c.818 0 1.578-.245 2.212-.667l.718.719a4.973 4.973 0 0 1-2.43.923V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 1 0v1a4 4 0 0 0 4 4zm3-9v4.879l-1-1V3a2 2 0 0 0-3.997-.118l-.845-.845A3.001 3.001 0 0 1 11 3z"/>
                            <path d="m9.486 10.607-.748-.748A2 2 0 0 1 6 8v-.878l-1-1V8a3 3 0 0 0 4.486 2.607zm-7.84-9.253 12 12 .708-.708-12-12-.708.708z"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                      </button>
                      <p class="m-0" :class="{'text-danger': !remoteSwitches[item.id] || !remoteSwitches[item.id]['audio'], 'text-success': remoteSwitches[item.id] && remoteSwitches[item.id]['audio'], }">{{ item.name }}</p>
                    </div>
                  </div>
                </div>
              </template>
            </div>
          </div>

          <div
            v-if="user && model && model.user_id !== user.id"
            id="room_local_stream"
            class="position-absolute bottom-0 pe-5">
            <div class="d-flex flex-wrap flex-center video-item overflow-hidden">
              <div class="d-flex flex-center w-100 h-100">
                <video
                  v-if="localStreams['video'] || localStreams['display']"
                  :srcObject.prop="localStreams['video'] ? localStreams['video'] : localStreams['display']"
                  muted
                  playsinline
                  autoplay
                  class="w-100">
                  Your browser does not support the video tag.
                </video>
                <img
                  v-else
                  alt="Pic"
                  class="w-100"
                  src="/img/avatar.png"
                  style="max-height: 100%;">
              </div>
              <p class="text-danger" style="margin-top: -25px">{{ user.name }}</p>
            </div>
          </div>

        </div>
        <!--end::Sidebar-->
      </div>
      <!--end::Layout-->

    </div>
    <!--end::Modal body-->

    <div class="modal fade" :class="{'show d-block': !offline && (duration === 0)}">
      <!--begin::Modal dialog-->
      <div class="modal-dialog modal-lg">
        <!--begin::Modal content-->
        <div class="modal-content rounded">
          <!--begin::Modal body-->
          <div class="modal-body pt-0 pb-15 px-5 px-xl-20">
            <!--begin::Heading-->
            <div class="mb-13 text-center">
              <h1 class="mb-3">Notez l'expert</h1>
              <div class="text-muted fw-bold fs-5">Merci de laisser votre évaluation pour cet expert.</div>
            </div>
            <!--end::Heading-->

            <div class="d-flex flex-center flex-row-fluid">
              <div class="rating">

                <!--begin::Star 1-->
                <label class="rating-label" for="kt_rating_input_1">
                  <!--begin::Svg Icon-->
                  <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="black" />
                    </svg>
                  </span>
                  <!--end::Svg Icon-->
                </label>
                <input class="rating-input" v-model="rating" name="rating" value="1" type="radio" id="kt_rating_input_1" />
                <!--end::Star 1-->
                <!--begin::Star 2-->
                <label class="rating-label" for="kt_rating_input_2">
                  <!--begin::Svg Icon -->
                  <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="black" />
                    </svg>
                  </span>
                  <!--end::Svg Icon-->
                </label>
                <input class="rating-input" v-model="rating" name="rating" value="2" type="radio" id="kt_rating_input_2" />
                <!--end::Star 2-->
                <!--begin::Star 3-->
                <label class="rating-label" for="kt_rating_input_3">
                  <!--begin::Svg Icon -->
                  <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="black" />
                    </svg>
                  </span>
                  <!--end::Svg Icon-->
                </label>
                <input class="rating-input" v-model="rating" name="rating" value="3" type="radio" id="kt_rating_input_3" />
                <!--end::Star 3-->
                <!--begin::Star 4-->
                <label class="rating-label" for="kt_rating_input_4">
                  <!--begin::Svg Icon-->
                  <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="black" />
                    </svg>
                  </span>
                  <!--end::Svg Icon-->
                </label>
                <input class="rating-input" v-model="rating" name="rating" value="4" type="radio" id="kt_rating_input_4" />
                <!--end::Star 4-->

                <!--begin::Star 5-->
                <label class="rating-label" for="kt_rating_input_5">
                  <!--begin::Svg Icon-->
                  <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="black" />
                    </svg>
                  </span>
                  <!--end::Svg Icon-->
                </label>
                <input class="rating-input" v-model="rating" name="rating" value="5" type="radio" id="kt_rating_input_5" />
                <!--end::Star 5-->
              </div>
            </div>

            <!--begin::Actions-->
            <div class="d-flex flex-center flex-row-fluid pt-12">
              <button @click="rate" type="submit" class="btn btn-primary">Envoyez ma note</button>
            </div>
            <!--end::Actions-->
          </div>
          <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
      </div>
      <!--end::Modal dialog-->
    </div>

  </div>
</template>

<script>
import {useStore} from "vuex";
import {useRoute} from "vue-router";
import {computed, onMounted, ref, reactive, watch, nextTick} from "vue";
import CountDown from "./CountDown";
import ApiService from "../../services/api.service";
import {SET_ERRORS} from "../../services/store/form.module";
import {SET_ROOM} from "../../services/store/room.module";
import ChatDrawerButton from "../../components/utils/ChatDrawerButton";

export default {
  name: 'CallingFormation',
  components: {ChatDrawerButton, CountDown},
  setup() {
    const offerOptions = {
      offerToReceiveAudio: true,
      offerToReceiveVideo: true,
    }
    const configuration = {
      iceServers: [
        {
          urls: 'stun:stun.l.google.com:19302'
        },
        {
          urls: 'turn:turn.divii.fr:3478',
          credential: '12345678',
          username: 'divii'
        }
      ]
    }

    const store = useStore()

    const route = useRoute()

    const user = computed(() => store.getters.currentUser)

    const offline = ref(true)

    const users = ref([])

    const peerConnections = ref({})

    const hasCreateOffers = ref({})

    const remoteStreams = ref({})

    const localStreams = ref({})

    const remoteSwitches = ref({})

    const tracks = {}

    const localSwitches = ref({})

    const mainRemoteStream = ref(null)

    const state = reactive({order:0})

    const leave = (roomId) => {
      offline.value = true
      console.log("leave", roomId)
      Echo.leave('rooms.' + roomId)
    }

    const join = (roomId) => {
      offline.value = false
      console.log("join", roomId)
      Echo.join('rooms.' + roomId)
        .here((items) => {
          console.log("presences", items)
          users.value = items;
          state.order = items.length
        })
        .joining((user) => {
          console.log("joining", user)
          users.value.push(user);
          createOffer(user)
        })
        .leaving((user) => {
          console.log("leaving", user)
          users.value =  users.value.filter(u => u.id !== user.id);
          if(peerConnections.value[user.id]){
            peerConnections.value[user.id].close();
            peerConnections.value[user.id] = null
            tracks[user.id] = null
          }
        })
    }

    const listen = (roomId) => {
      console.log("listen", roomId)
      Echo.private('rooms.' + roomId)
        .listen('.message.created', (e) => {
          console.log("listen .message.created", e)
        })
    }

    const listenSignal = (roomId, userId) => {
      console.log("listenSignal", roomId, userId)
      Echo.private('rooms.' + roomId + '.' + userId)
        .listen('.signal', (e) => {
          console.log("listen .signal", e)
          if(e.content.sdp && !e.content.sdp.endsWith('\r\n')){
            e.content.sdp += '\r\n'
          }
          if(e.type === 'offer'){
            if(!peerConnections.value[e.from]){
              peerConnections.value[e.from] = createPeerConnection(e.from)
            }
            // Set Remote SDP and Create answer for the sender
            setRemoteDescription(peerConnections.value[e.from], e.from, e.content)
          }
          if(e.type === 'answer'){
            if(!peerConnections.value[e.from]){
              peerConnections.value[e.from] = createPeerConnection(e.from)
            }
            // Set Remote SDP and Create answer for me (=> do not create answer)
            setRemoteDescription(peerConnections.value[e.from], e.dest, e.content)
          }
          if(e.type === 'candidate'){
            if (!peerConnections.value[e.from]) {
              peerConnections.value[e.from] = createPeerConnection(e.from)
            }
            // Set candidate for the PC of sender
            addRemoteIceCandidate(peerConnections.value[e.from], e.from, e.content)
          }
          if(e.type === 'audio' || e.type === 'video' || e.type === 'display'){
            if(e.from === e.dest){
              localSwitches.value[e.type] = e.content
            }else{
              if(!remoteSwitches.value[e.from]){
                remoteSwitches.value[e.from] = {}
              }
              remoteSwitches.value[e.from][e.type] = e.content
            }
          }
        })
    }

    const duration = ref(null)

    const model = ref(null)
    const loadModel = () => {
      console.log('loadModel')
      store.commit(SET_ROOM, null)
      ApiService.get('/account/rooms/' + route.params.id)
        .then((response) => {
          if(response.data.success) {
            model.value = response.data.data
            store.commit(SET_ROOM, model.value)
            const value = Math.floor(moment(model.value.end_at).diff(moment()) / 1000)
            if(value > 0){
              duration.value = value
              if(duration.value > 5 * 60){
                setTimeout(() => {openPopup("5 minutes")}, (duration.value - 5 * 60) * 1000);
              }
              if(duration.value > 2 * 60){
                setTimeout(() => {openPopup("2 minutes")}, (duration.value - 2 * 60) * 1000);
              }
              if(duration.value > 0){
                setTimeout(stop, duration.value * 1000);
              }
            }else{
              console.error('Duration = 0', value, model.value.end_at)
              duration.value = 0
            }
            loadDurations()
          }
        })
        .catch(({response}) => {
          if(response && response.data && response.data.errors){
            store.commit(SET_ERRORS, response.data.errors);
          }
        })
    }
    onMounted(loadModel)

    const start = function(){
      console.log('start call');
      if(model.value){
        join(model.value.id)
        listen(model.value.id)
        if(user.value){
          listenSignal(model.value.id, user.value.id)
        }
      }
    }

    const stop = function(){
      if(model.value){
        leave(model.value.id)
      }
    }

    const hasListen = ref(false)
    watch(() => user.value, (value) => {
      if(hasListen.value){
        return;
      }
      if(value) {
        if(model.value){
          listenSignal(model.value.id, value.id)
          hasListen.value = true
        }
      }
    })

    const isExpert = computed(() => {
      const value = model.value && user.value && (model.value.user_id === user.value.id)
      console.log("isExpert", value)
      return value
    })

    const expertOnline = computed(() => {
      console.log("expertOnline")
      if(isExpert.value){
        console.log("expertOnline TRUE")
        return true
      }
      if(model.value){
        users.value.forEach((item) => {
          console.log("expertOnline", item.id, model.value.user_id)
          if(item.id === model.value.user_id){
            console.log("expertOnline TRUE")
            return true
          }
        })
      }
      console.log("expertOnline FALSE")
      return false
    })

    const onIceCandidate = (pc, dest, event) => {
      if (event.candidate){
        console.log(pc + ' ICE candidate: \n' + (event.candidate ? event.candidate.candidate : '(null)'));
        if(event.candidate.candidate){
          console.log('event.candidate.candidate => TRUE')
          signal({type:'candidate', content:event.candidate, dest:dest});
        }else{
          console.warn('event.candidate.candidate => FALSE')
        }
      }
    }

    const onIceConnectionStateChange = (pc, dest, event) => {
      console.log((new Date()).toISOString() + 'ICE Connection state Change: ' + pc.iceConnectionState, dest);
      if(pc.iceConnectionState === 'connected'){
        if(localSwitches.value['audio']){
          getAudioStream(dest)
        }
        if(localSwitches.value['display']){
          getDisplayStream(dest)
        }else if(localSwitches.value['video']){
          getVideoStream(dest)
        }
      }
    }

    const onNegotiationNeeded = (pc, dest, options) => {
      console.error('Negotiation Needed: ' + pc.signalingState, dest);
      if (pc.signalingState !== "stable") return;
      pc.createOffer(options)
        .then(
          (desc) => {
            onCreateOfferSuccess(pc, dest, desc)
          },
          (error) => {
            onCreateOfferError(pc, dest, error)
          }
        )
      hasCreateOffers.value[dest] = new Date()
    }

    const createPeerConnection = (dest) => {
      const pc = new RTCPeerConnection(configuration);
      pc.onicecandidate = (event) => { onIceCandidate(pc, dest, event) }
      pc.oniceconnectionstatechange =  (event) => { onIceConnectionStateChange(pc, dest, event) }
      pc.onnegotiationneeded = (options) => { onNegotiationNeeded(pc, dest, options) }
      pc.addEventListener('track', (event) => { gotRemoteTrack(pc, dest, event) });
      return pc;
     }

    const onSetLocalDescriptionSuccess = (pc, dest) => {
      console.log('setLocalDescription complete', dest);
    }

    const onSetLocalDescriptionError = (pc, dest, error) => {
      console.error('Failed to set local description: ' + error.toString(), dest);
    }

    const onCreateOfferSuccess = (pc, dest, desc) => {
      console.log('onCreateOfferSuccess');
      signal({type:'offer', content:desc, dest:dest});
      pc.setLocalDescription(desc)
        .then(
          () => {
            onSetLocalDescriptionSuccess(pc, dest);
          },
          (error) => {
            onSetLocalDescriptionError(pc, dest, error)
          }
        );
    }

    const onCreateOfferError = (pc, dest, error) => {
      console.error('Failed to create offer error: ' + error.toString());
    }

    const createOffer = (newUser) => {
      if(!user.value){
        console.error('createOffer');
        return;
      }

      console.warn('createOffer ' + newUser.id);

      if(!peerConnections.value[newUser.id]){
        peerConnections.value[newUser.id] = createPeerConnection(newUser.id)
        peerConnections.value[newUser.id].createOffer(offerOptions)
          .then(
            (desc) => {
              onCreateOfferSuccess(peerConnections.value[newUser.id], newUser.id, desc)
            },
            (error) => {
              onCreateOfferError(peerConnections.value[newUser.id], newUser.id, error)
            }
          )
        hasCreateOffers.value[newUser.id] = new Date()
      }
    }

    const onCreateAnswerSuccess = (pc, dest, desc) => {
      console.log('onCreateAnswerSuccess', dest);
      if(desc.sdp){
        desc.sdp = desc.sdp.replace('useinbandfec=1', 'useinbandfec=1; stereo=1; maxaveragebitrate=510000');
      }
      signal({type:'answer', content:desc, dest:dest});
      pc.setLocalDescription(desc)
        .then(
          () => {
            onSetLocalDescriptionSuccess(pc, dest);
          },
          (error) => {
            onSetLocalDescriptionError(pc, dest, error)
          }
        );
    }

    const onCreateAnswerError = (pc, dest, error) => {
      console.error('Failed to create answer: ' + error.toString(), dest);
    }

    const createAnswer = (pc, dest) => {
      console.log('createAnswer', dest);
      pc.createAnswer()
        .then(
          (desc) => {
            onCreateAnswerSuccess(pc, dest, desc)
          },
          (error) => {
            onCreateAnswerError(pc, dest,error)
          }
        )
    }

    const onSetRemoteDescriptionSuccess = (pc, dest) => {
      console.log('setRemoteDescription complete', dest);
      if(dest !== user.value.id){
        createAnswer(pc, dest)
      }
    }

    const onSetRemoteDescriptionError = (pc, dest, error) => {
      console.error('Failed to set remote description: ' + error.toString(), dest);
    }

    const setRemoteDescription = (pc, dest, desc, date) => {
      console.log('setRemoteDescription');
      if(hasCreateOffers.value[dest] && (hasCreateOffers.value[dest] >= new Date(date))){
        console.error('setRemoteDescription canceled');
        return;
      }

      pc.setRemoteDescription(desc)
        .then(
          () => {
            onSetRemoteDescriptionSuccess(pc, dest)
          },
          (error) => {
            onSetRemoteDescriptionError(pc, dest, error)
          }
        );
    }

    const onRemoteAddIceCandidateSuccess = (pc, dest) => {
      console.log('onRemoteAddIceCandidateSuccess', dest);
    }

    const onRemoteAddIceCandidateError = (pc, dest, error) => {
      console.error('onRemoteAddIceCandidateError ' + error.toString(), dest);
    }

    const addRemoteIceCandidate = (pc, dest, candidate) => {
      console.log('addRemoteIceCandidate', dest);
      pc.addIceCandidate(candidate)
        .then(
          () => {
            onRemoteAddIceCandidateSuccess(pc, dest);
          },
          (error) => {
            onRemoteAddIceCandidateError(pc, dest, error);
          }
        );
    }

    const getAudioStream = (userId) => {
      console.log('get audio stream');
      const type = 'audio'
      if(localStreams.value[type]){
        gotStream(localStreams.value[type], type, userId)
        return;
      }
      const audioConstraints = {
        autoGainControl: false,
        channelCount: 2,
        echoCancellation: false,
        latency: 0,
        noiseSuppression: false,
        sampleRate: 48000,
        sampleSize: 16,

        googEchoCancellation: false,
        googAutoGainControl: false,
        googNoiseSuppression: false,
        googHighpassFilter: false
      }
      navigator.mediaDevices
        .getUserMedia({
          audio: audioConstraints,
        })
        .then((stream) => {
          gotStream(stream, type, userId)
        })
        .catch(function(e) {
          console.error('getUserMedia() audio error: ' + e.name);
          localSwitches.value[type] = false
        });
    }

    const getVideoStream = (userId) => {
      console.log('get video stream');
      const type = 'video'
      if(localStreams.value[type]){
        gotStream(localStreams.value[type], type, userId)
        return;
      }
        navigator.mediaDevices
          .getUserMedia({
            //video: {width: {exact:320},height:{exact: 240}}
            video: true,
          })
          .then((stream) => {
            localSwitches.value['display'] = false
            gotStream(stream, type, userId)
          })
          .catch(function(e) {
            console.error('getUserMedia() video error: ' + e.name);
            localSwitches.value[type] = false
          });
    }

    const getDisplayStream = (userId) => {
      console.log('get display stream');
      const type = 'display'
      if(localStreams.value[type]){
        gotStream(localStreams.value[type], type, userId)
        return;
      }
      navigator.mediaDevices
        .getDisplayMedia({video: true})
        .then((stream) => {
          localSwitches.value['video'] = false
          gotStream(stream, type, userId)
        })
        .catch(function(e) {
          console.error('getDisplayMedia() error: ' + e.name);
          localSwitches.value[type] = false
        })
    }

    const gotStream = (stream, type, userId) => {
      console.log('Received stream', type, userId);
      localStreams.value[type] = stream
      const kind = type !== 'audio' ? 'video' : 'audio'
      const newTrack = getTrack(stream, kind)
      if(userId){
        const oldTrack = findTrack(userId, kind)
        if(oldTrack){
          oldTrack.replaceTrack(newTrack)
        }else{
          addTrack(userId, newTrack, stream)
        }

        signal({type:type, content:true, dest: userId})
      }else{
        users.value.forEach((item) => {
          const oldTrack = findTrack(item.id, kind)
          if(oldTrack){
            oldTrack.replaceTrack(newTrack)
          }else{
            addTrack(item.id, newTrack, stream)
          }

          if(item.id !== user.value.id){
            signal({type:type, content:true, dest: item.id})
          }
        })
      }
    }

    const getTrack = (stream, kind) => {
      return stream.getTracks().find(track => track.kind === kind)
    }

    const findTrack = (userId, kind) => {
      if(tracks[userId]){
        console.log("track found " + userId + " with " + kind)
        return tracks[userId].find(item => item.track.kind === kind)
      }
      console.warn("track NOT found " + userId + " with " + kind)
      return null
    }

    const addTrack = (userId, newTrack, stream) => {
      if(!peerConnections.value[userId]){
        console.warn("no track for " + userId)
        return;
      }
      console.log("add track for " + userId)
      if(!tracks[userId]){
        tracks[userId] = []
      }
      tracks[userId].push(peerConnections.value[userId].addTrack(newTrack, stream))
    }

    const stopTracks = (stream) => {
      if(!stream) return;
      stream.getTracks().forEach((track) => track.stop());
    }

    const addOrReplaceRemoteTrack = (localStream, remoteStream, kind) => {
      if(remoteStream){
        const track = remoteStream.getTracks().find(track => track.kind === kind)
        if(track){
          console.log("addOrReplaceRemoteTrack " + kind)
          const current = localStream.getTracks().find(track => track.kind === kind);
          if(current){
            if("function" !== typeof current.replaceTrack){
              localStream.addTrack(track)
            }else{
              current.replaceTrack(track);
            }
          }else{
            localStream.addTrack(track)
          }
        }
      }
    }

    const gotRemoteTrack = (pc, dest, event) => {
      console.log('get remote track', dest, model.value.user_id);
      if(!remoteStreams.value[dest]){
        remoteStreams.value[dest] = event.streams[0]
      }else{
        addOrReplaceRemoteTrack(remoteStreams.value[dest], event.streams[0], 'audio')
        addOrReplaceRemoteTrack(remoteStreams.value[dest], event.streams[0], 'video')
      }

      if(dest === model.value.user_id){
        console.log("Get expert stream")
        if(!mainRemoteStream.value){
          mainRemoteStream.value = event.streams[0]
        }else{
          addOrReplaceRemoteTrack(mainRemoteStream.value, event.streams[0], 'audio')
          addOrReplaceRemoteTrack(mainRemoteStream.value, event.streams[0], 'video')
        }
      }

      nextTick(() => {
        console.log("Auto play nextTick")
        const element = document.getElementById("remote-stream-" + dest)
        if(element){
          console.log("Auto play executed")
          element.play()
        }
      })
    }

    const signal = (message, from) => {
      message.from = from ? from : user.value.id
      message.date = (new Date()).toISOString()
      console.log('signal', message)
      ApiService.post('/account/rooms/' + route.params.id + '/signal' , message);
    }

    const signalStream = (kind, value) => {
      console.log("signalStream", kind, value)
      // Signal other users
      users.value.forEach((item) => {
        console.log(kind + " item.id => " + item.id)
        if(item.id !== user.value.id){
          signal({type:kind, content: value, dest: item.id});
        }
      })
    }

    const toggleMic = (userID) => {
      console.log("toggleMic", userID)
      // Signal all users
      users.value.forEach((item) => {
        console.log("toggleMic audio item.id => " + item.id)
        signal({type:'audio', content: !(remoteSwitches.value[userID] && remoteSwitches.value[userID]['audio']), dest: item.id}, userID);
      })
    }

    watch(() => localSwitches.value['audio'], (newValue) => {
      if(newValue){
        getAudioStream()
      }else{
        stopTracks(localStreams.value['audio'])
        localStreams.value['audio'] = null
        signalStream('audio', false)
      }
    })

    watch(() => localSwitches.value['video'], (newValue) => {
      if(newValue){
        getVideoStream()
      }else{
        stopTracks(localStreams.value['video'])
        localStreams.value['video'] = null
        signalStream('video', false)
      }
    })

    watch(() => localSwitches.value['display'], (newValue) => {
      if(newValue){
        getDisplayStream()
      }else{
        stopTracks(localStreams.value['display'])
        localStreams.value['display'] = null
        signalStream('display', false)
      }
    })

    const hasRemoteVideo = (id) => {
      return remoteSwitches.value[id] && (remoteSwitches.value[id].display ||  remoteSwitches.value[id].video)
    }

    const openPopup = (delay) => {
      Swal.fire({
        title: "Attention! Il vous reste " + delay + " d'appel.",
        icon: "warning",
        showCancelButton: false,
        confirmButtonText: t('yes'),
      })
    }

    const getData = () => {
      const data = {}
      data.date = model.value.end_at
      if(durationModel.value){
        data.duration_id = durationModel.value.id
      }else{
        data.duration_id = null
      }
      return data
    }

    const continueRoom = () => {
      closeModal()
      const data = getData()
      axios.post('/api/v1/experts/' + model.value.user_id + '/consultations', data)
        .then((response) => {
          store.commit(SET_ERRORS, {})
          if(response.data.success) {
            if(response.data.order){
              console.warn('OK', response.data.order)
            }else{
              console.error('KO', response.data.message)
            }
            loadModel()
          }else{
            Swal.fire(
              'Oups!',
              response.data.message,
              'warning'
            )
          }
        })
    }

    const durationModel = ref(null)
    const loadDurations = () => {
      durationModel.value = null
      ApiService.get('/experts/' + model.value.user_id + '/durations', null)
        .then(({data}) => {
          if(data.success) {
            durationModel.value = data.data.length ? data.data[0] : null
          }
        })
    }

    const rating = ref(0)
    const rate = () => {
      const data = {
        value: rating.value ? rating.value : 0
      }
      axios.post('/api/v1/account/rooms/' + route.params.id + '/ratings', data)
        .then((response) => {
          store.commit(SET_ERRORS, {})
          if(response.data.success) {
            toastr.success("Votre note est bien reçue! Merci.");
            location.href = "/auth/login"
          }else{
            Swal.fire(
              'Oups!',
              "Une erreur s'est produite.",
              'warning'
            )
          }
        })
    }

    return {
      offline,
      state,
      duration,
      user,
      users,
      route,
      model,
      mainRemoteStream,
      localStreams,
      remoteStreams,
      localSwitches,
      remoteSwitches,
      isExpert,
      expertOnline,
      durationModel,
      rating,
      rate,
      hasRemoteVideo,
      continueRoom,
      stop,
      start,
      toggleMic,
    }
  }
}
</script>
