import{v as d,c as u,w as i,o as r,a,u as s,X as c,f as _,t as f,l as p,b as t,d as w,n as b,e as g}from"./app-aa23e15a.js";import{_ as y}from"./GuestLayout-888db223.js";import{_ as x,a as k,b as h}from"./TextInput-99cdeb10.js";import{_ as v}from"./PrimaryButton-3fa5a2ac.js";import"./ApplicationLogo-976be338.js";const V=t("div",{class:"mb-4 text-sm text-gray-600"}," Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one. ",-1),N={key:0,class:"mb-4 font-medium text-sm text-green-600"},$=["onSubmit"],B={class:"flex items-center justify-end mt-4"},q={__name:"ForgotPassword",props:{status:String},setup(o){const e=d({email:""}),m=()=>{e.post(route("password.email"))};return(S,l)=>(r(),u(y,null,{default:i(()=>[a(s(c),{title:"Forgot Password"}),V,o.status?(r(),_("div",N,f(o.status),1)):p("",!0),t("form",{onSubmit:g(m,["prevent"])},[t("div",null,[a(x,{for:"email",value:"Email"}),a(k,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:s(e).email,"onUpdate:modelValue":l[0]||(l[0]=n=>s(e).email=n),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),a(h,{class:"mt-2",message:s(e).errors.email},null,8,["message"])]),t("div",B,[a(v,{class:b({"opacity-25":s(e).processing}),disabled:s(e).processing},{default:i(()=>[w(" Email Password Reset Link ")]),_:1},8,["class","disabled"])])],40,$)]),_:1}))}};export{q as default};
