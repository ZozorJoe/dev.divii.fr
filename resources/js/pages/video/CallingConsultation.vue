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
          <div v-if="!isExpert && model.user" class="text-center">
            <div class="mb-15">
              <!--begin::Wrapper-->
              <div class="mb-5">
                <!--begin::Avatar-->
                <div class="symbol symbol-75px symbol-circle">
                  <img alt="Pic" :src="`/u/image-${model.user.id}.jpg`">
                </div>
                <!--end::Avatar-->
              </div>
              <!--end::Wrapper-->

              <!--begin::Name-->
              <a href="#" class="fs-4 text-gray-800 text-hover-primary fw-bolder mb-0">{{ model.user.name }}</a>
              <!--end::Name-->

              <!--begin::Position-->
              <div v-if="model.user.disciplines && model.user.disciplines.length" class="fw-bold text-gray-400 mb-6">{{ model.user.disciplines[0].name }}</div>
              <!--end::Position-->
            </div>

            <!--begin::Heading-->
            <div class="mb-10">
              <h1 v-if="model.consultation && model.consultation.duration" class="mb-3">
                Consultation de
                {{ model.consultation.duration.label }}
                avec
                {{ model.user.name }}
              </h1>
              <h1 v-else class="mb-3">
                {{ model.title }}
                avec
                {{ model.user.name }}
              </h1>
            </div>
            <!--end::Heading-->
          </div>

          <div v-if="isExpert && model.consultation" class="text-center">
            <div class="mb-15">
              <!--begin::Wrapper-->
              <div v-if="model.consultation.customer" class="mb-5">
                <!--begin::Avatar-->
                <div class="symbol symbol-75px symbol-circle">
                  <img alt="Pic" :src="`/u/image-${model.consultation.customer.id}.jpg`">
                </div>
                <!--end::Avatar-->
              </div>
              <!--end::Wrapper-->

              <!--begin::Name-->
              <a v-if="model.consultation.customer" href="#" class="fs-4 text-gray-800 text-hover-primary fw-bolder mb-0">{{ model.consultation.customer.name }}</a>
              <!--end::Name-->
            </div>

            <!--begin::Heading-->
            <div class="mb-10">
              <h1 v-if="model.consultation.duration" class="mb-3">
                Consultation de
                {{ model.consultation.duration.label }}
                avec
                {{ model.consultation.customer.name }}
              </h1>
              <h1 v-else class="mb-3">
                {{ model.title }}
                avec
                {{ model.consultation.customer.name }}
              </h1>
            </div>
            <!--end::Heading-->
          </div>

          <!--begin::CountDown-->
          <div class="mb-10">
            <CountDown v-model="duration" :duration="duration" />
          </div>
          <!--end::CountDown-->

          <!--begin::Link-->
          <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a href="/auth/login" class="btn btn-flex btn-light btn-active-primary fw-bolder">
              Retours
            </a>
            <button v-if="duration >= 0 && !isExpert && ringing" @click="accept" class="btn btn-success ml-2">
              Répondre
            </button>
            <button v-if="duration >= 0 && isExpert && !dialing" @click="dial" class="btn btn-success ml-2">
              Appeler
            </button>
            <button v-if="duration >= 0 && isExpert && dialing" @click="cancel" class="btn btn-danger ml-2">
              Annuler
            </button>
          </div>
          <!--end::Link-->

          <audio ref="audio" preload="auto" class="sound-player" loop="loop" style="display:none;">
            <source src="/audio/call.mp3" />
            <embed src="/audio/call.mp3" hidden="true"/>
          </audio>

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

        <!--begin::Separator-->
        <span class="h-20px border-gray-200 border-start mx-4"></span>
        <!--end::Separator-->

        <a href="/auth/login" @click="terminer" class="btn btn-sm btn-danger ml-2">
          Terminer
        </a>

      </div>

    </div>
    <!--end::Modal header-->

    <!--begin::Modal body-->
    <div v-if="!offline" class="modal-body py-0" id="kt_room_body">

      <!--begin::Layout-->
      <div class="d-flex flex-column flex-lg-row h-100">
        <!--begin::Content-->
        <!--end::Content-->
        <!--begin::Sidebar-->
        <div class="flex-lg-row-auto w-100 mb-10 mb-lg-0 ps-2">
              <iframe 
                id="conferenceIframe"
                 v-if="jitsi.showCustomer"
                  :src="jitsi.customer_url"
                  height="100%"
                  width="100%"
                  frameborder="0"
                   allow="camera *;microphone *"                  
                ></iframe>              
              <iframe 
                id="conferenceIframe1"
              v-if="jitsi.showExpert"
                  :src="jitsi.expert_url"
                  height="100%"
                  width="100%"
                  frameborder="0"
                   allow="camera *;microphone *"                  
                ></iframe>              
        </div>

        <!--end::Sidebar-->
      </div>
      <!--end::Layout-->

    </div>
    <!--end::Modal body-->

    <div class="modal fade" :class="{'show': modal, 'd-block': modal}">
      <!--begin::Modal dialog-->
      <div class="modal-dialog modal-lg">
        <!--begin::Modal content-->
        <div class="modal-content rounded">
          <!--begin::Modal header-->
          <div class="modal-header justify-content-end border-0 pb-0">
            <!--begin::Close-->
            <div @click="closeModal" class="btn btn-sm btn-icon btn-active-color-primary">
              <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
              <span class="svg-icon svg-icon-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                  <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                </svg>
              </span>
              <!--end::Svg Icon-->
            </div>
            <!--end::Close-->
          </div>
          <!--end::Modal header-->
          <!--begin::Modal body-->
          <div class="modal-body pt-0 pb-15 px-5 px-xl-20">
            <!--begin::Heading-->
            <div class="mb-13 text-center">
              <h1 class="mb-3">Réservation</h1>
              <div class="text-muted fw-bold fs-5">Vous voulez continuer la discussion?</div>
            </div>
            <!--end::Heading-->
            <!--begin::Actions-->
            <div class="d-flex flex-center flex-row-fluid pt-12">
              <button @click="closeModal" type="reset" class="btn btn-light me-3">Non</button>
              <button @click="continueRoom" type="submit" class="btn btn-primary">Oui, ajouter 15 minutes</button>
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
  name: 'CallingConsultation',
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

    const jitsi = reactive({
      showCustomer: false,
      customer_url: "",
      showExpert: false,
      expert_url: "",
    });

    const leave = (roomId) => {
      offline.value = true
      console.log("leave", roomId)
      Echo.leave('rooms.' + roomId)
    }

    const initJitsiIframeForExpert = () => {
      offline.value = false;
      let meeting_room_name = "Divii.fr - " + model.value.consultation.name + " between " + model.value.consultation.customer.name + " and " + model.value.user.name;
      jitsi.showExpert = true;
      jitsi.expert_url = `/initiate/jitsi-meet/meeting?callback=/login&roomname=${meeting_room_name}&displayName=${model.value.user.name}&email=${model.value.user.email}`;
      // reloadIframe("conferenceIframe1");

    }

    const reloadIframe = (elem) => {
      setTimeout(() => {
        var _iframe = window.parent.document.getElementById(elem);
        _iframe.contentWindow.location.reload(true);
      }, 500);
    }

    const initJitsiIframeForCustomer = () => {
      offline.value = false;
      let meeting_room_name = "Divii.fr - " + model.value.consultation.name + " between " + model.value.consultation.customer.name + " and " + model.value.user.name;
      jitsi.showCustomer = true;
      jitsi.customer_url = `/initiate/jitsi-meet/meeting?callback=/login&roomname=${meeting_room_name}&displayName=${model.value.consultation.customer.name}&email=${model.value.consultation.customer.email}`;
      // reloadIframe("conferenceIframe");

    }


    const initJitsiOptions = (name, from, to) => {
      JITSIOPTIONS.roomName = `Divii.fr ${name} between ${from} & ${to}`;
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
          initiateJitsiIframe();
          // createOffer(user)

        })
        .leaving((user) => {
          console.log("leaving", user)
          users.value =  users.value.filter(u => u.id !== user.id);
          leave(roomId)
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
          switch (e.type){
            case 'offer':
              if(!peerConnections.value[e.from]){
                peerConnections.value[e.from] = createPeerConnection(e.from)
              }
              // Set Remote SDP and Create answer for the sender
              setRemoteDescription(peerConnections.value[e.from], e.from, e.content)
            break;
            case 'answer':
              if(!peerConnections.value[e.from]){
                peerConnections.value[e.from] = createPeerConnection(e.from)
              }
              // Set Remote SDP and Create answer for me (=> do not create answer)
              setRemoteDescription(peerConnections.value[e.from], e.dest, e.content)
            break;
            case 'candidate':
              if (!peerConnections.value[e.from]) {
                peerConnections.value[e.from] = createPeerConnection(e.from)
              }
              // Set candidate for the PC of sender
              addRemoteIceCandidate(peerConnections.value[e.from], e.from, e.content)
            break;
            case 'audio':
            case 'video':
            case 'display':
              if(e.from === e.dest){
                localSwitches.value[e.type] = e.content
              }else{
                if(!remoteSwitches.value[e.from]){
                  remoteSwitches.value[e.from] = {}
                }
                remoteSwitches.value[e.from][e.type] = e.content
              }
            break;
            case 'calling': // From expert to customer
              if(offline.value){
                ringing.value = true
                console.log("RINGING")
              }else{
                ringing.value = false
                console.error("RINGING ONLINE")
              }
            break;
            case 'canceling': // From expert to customer
              ringing.value = false
              console.log("RING STOP")
            break;
            case 'accepting': // From customer to expert
              dialing.value = false;
              initJitsiIframeForExpert();
            break;
            case 'terminer': // From customer to expert
              window.location.href = "/auth/login";
            break;            
          }
        })
    }

    const duration = ref(0)

    const model = ref(null)
    const loadModel = () => {
      console.log('loadModel')
      store.commit(SET_ROOM, null)
      ApiService.get('/account/rooms/' + route.params.id)
        .then((response) => {
          if(response.data.success) {
            model.value = response.data.data
            let r = response.data.datal
            initJitsiOptions(r.consultation.name, r.consultation.customer.name, r.user.name );

            store.commit(SET_ROOM, model.value)
            const value = Math.floor(moment(model.value.end_at).diff(moment()) / 1000)
            if(value > 0){
              duration.value = value
              if(duration.value > 5 * 60){
                setTimeout(openModal, (duration.value - 5 * 60) * 1000);
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
      }
    }

    watch(() => model.value, (value) => {
      if(value){
        console.log('watch model.value');
        listen(model.value.id)
        if(user.value){
          listenSignal(model.value.id, user.value.id)
        }
      }
    })

    const stop = function(){
      if(model.value){
        leave(model.value.id)
      }
    }

    const dialing = ref(false)
    const ringing = ref(false)

    const dial = () => {
      console.log("dial")
      dialing.value = true
      signalCall()
    }

    const terminer = () => {
      console.log("cancel")
      dialing.value = false
      if(model.value && model.value.consultation) {
        signal({type: 'canceling', content: model.value.id, dest: model.value.consultation.customer_id});
        signal({type: 'terminer', content: model.value.id, dest: model.value.consultation.customer_id});
      }
    }


    const cancel = () => {
      console.log("cancel")
      dialing.value = false
      if(model.value && model.value.consultation) {
        signal({type: 'canceling', content: model.value.id, dest: model.value.consultation.customer_id});
      }
    }

    const accept = () => {
      console.log("accept")
      ringing.value = false
      if(model.value) {
        signal({type: 'accepting', content: model.value.id, dest: model.value.user_id});
      }
      initJitsiIframeForCustomer();
    }

    const signalCall = () => {
      if(!dialing.value){
        console.log("signalCall STOP", model.value)
        return;
      }
      console.log("signalCall SEND", model.value)
      if(model.value && model.value.consultation){
        console.log("signalCall", model.value.consultation)
        signal({type:'calling', content: model.value.id, dest: model.value.consultation.customer_id});
        setTimeout(signalCall, 1000);
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
            video: {width: {exact:320},height:{exact: 240}}
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
        }else{
          console.log('track is not found')
        }
      }else{
        console.log('remoteStream is null')
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

    const modal = ref(false)
    const openModal = () => {
      modal.value = durationModel.value && !isExpert.value
      console.log('openModal', modal.value)
    }
    const closeModal = () => {modal.value = false}

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


    const audio = ref(null)
    watch(() => ringing.value, (value) => {
      if(audio.value){
        if(value){
          try{
            audio.value.play()
          }catch (e){
            ringing.value = false
          }
        }else{
          audio.value.pause();
          audio.value.currentTime = 0;
        }
      }
    })

    return {
      audio,
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
      modal,
      isExpert,
      expertOnline,
      durationModel,
      dialing,
      ringing,
      dial,
      cancel,
      accept,
      hasRemoteVideo,
      continueRoom,
      openModal,
      closeModal,
      stop,
      start,
      toggleMic,
      jitsi,
      terminer
    }
  }
}
</script>
