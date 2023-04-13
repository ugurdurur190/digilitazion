@extends('layouts.menu')
@section('content')

<h4>Kullanım Kılavuzu:</h4>
<hr color="#660066;"/>
<div class="row rounded" style="background-color: #FFFFFF;">

    
    <div class="col-9">
        <!-- Admin User Guide -->
        @if(Auth::user()->privilege_id == 1)
            <h3 style="color:#660066;">"Admin Kullanıcısı" İçin Kullanım Kılavuzu:</h3><br/>
         
            <h3 style="color:#660066;">Kullanıcılar:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/user_list.png') }}" alt=""></div>
            <p>-Menüde ki "Kullanıcılar" kısmında, "Kullanıcı" ve "Birim" ekleme,düzenleme ve silme işlemleri gerçekleştirilir.</p>
            <h5 style="color:#8B0000;">Yeni kullanıcı ekle:</h5>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/new_user.png') }}" alt=""></div>
            <p>-Sistemde 5 tür kullanıcı türü vardır.</p>
            <p>-<b>"Admin"</b> olan kullanıcıların diğer kullanıcılardan farklı olarak yeni kullanıcı ve yeni birim ekleme,düzenleme,silme işlemlerini gerçekleştirir. Kullanıcıların proje fikirlerini girebileceği proje formları oluşturur.
                Ve bir projenin değerlendirme anketi oylamaya açılmadan bu ankete soru ekleyebilir ve çıkartabilir. Oylama sonucuna göre projeleri filtreleyebilir(Oylamada,Devam eden,Tamamlanan,İptal) örneğin oylamada olan bir projenin devam edip etmeyeceğini admin ayarlayabilir. 
            </p>
            <p>-<b>"Personel"</b> olan kullanıcılar proje formlarını doldurup gönderebilir. Projeleri oylayabilir. Projelerde çalışabilir.</p>
            <p>-<b>"Yönetici"</b> olan kullanıcılar proje formlarını doldurup gönderebilir. Projeleri oylayabilir. Projelerde çalışabilir. Bu kullanıcının oyu diğer kullanıcılara göre 10 kat daha etkilidir.</p>
            <p>-<b>"Birim Yöneticisi"</b> olan kullanıcılar eğer bir projenin etkilenen birimlerinden ise kendi birimlerinin proje onayını verebilirler. Eğer birim yöneticisi birim onayını vermezse proje oylamaya açılamaz. Ve proje formlarını doldurup gönderebilir. Projeleri oylayabilir. Projelerde çalışabilir.</p>
            <p>-<b>"Developer"</b> olan kullanıcılar sadece proje alanında çalışabilirler. Proje formunu dolduramaz ve oylamalara katılamazlar.</p>
            <br/>
            <h5 style="color:#8B0000;">Kullanıcı düzenle ve sil:</h5>
            <p>Kullanıcı listesinde ki <b>"Aksiyon"</b> alanında kullanıcı düzenleme ve silme butonlarına basılarak işlem yapılır.</p>
            <p><i style="color: black;" class="fa fa-edit fa-lg"></i> butonuna basınca kullanıcının isim,email,şifre ve kullanıcı türü düzenlenebilir.</p>
            <br/>
            <h3 style="color:#660066;">Proje Formu:</h3>
            <hr color="#660066;"/>
            <p>Proje fikirlerinizi "Proje Formunu" doldurarak gönderebilirsiniz. Projeden "Etkilenen Birimler" projeyi onaylarsa projeniz oylamaya açılacaktır.</p>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/project_forms.png') }}" alt=""></div>
            <p>"<i style="color: black;" class="fa fa-plus"></i> YENİ FORM OLUŞTUR" butonuna basınca açılan sayfada form ismini,açıklamasını ve başlangıç-bitiş tarihlerini girerek yeni form oluşturabilirsiniz. Proje formlarını sadece Admin oluşturabilir,düzenleyebilir ve silebilir.</p>
            <p><i style="color: black;" class="fa fa-edit fa-lg"></i> butonuna basınca form ismini ve açıklamasını düzenleyebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" soru ve mevcut süreçler ekleyebilir,soruları kaldırabilirsiniz.</p>
            <p><a href="">Devam Eden Proje Gir</a> butonuna basınca açılan sayfadaki form <i style="color: black;" class="fa fa-eye fa-lg"></i> sayfasındaki form ile aynıdır. Bu forma birim onayı ve oylama aşaması tamamlanmış projeler girilir. Formun en altında formu dolduran kullanıcıdan proje değerlendirme oranı girmesini ister.</p>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/project_form_view.png') }}" alt=""></div><br/>
            <p>"<i style="color:black;" class="fa fa-plus fa-lg"> Yeni Soru Oluştur</i>" butonuna basınca açılan pencereden 3 tür soru tipi ekleyebilirsiniz.</p>
            <p>"<i style="color:black;" class="fa fa-plus fa-lg"> Mevcut Süreç Oluştur</i>" butonuna basınca açılan pencereden "Mevcut Süreç" ekleyebilirsiniz.</p>
            <br/>
            <h3 style="color:#660066;">Proje Düzenle:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/project_edit.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan "Proje Düzenleme Sayfası" ile projelerinizi güncelleyebilirsiniz. soru ve mevcut süreçler ekleyebilir,soruları kaldırabilirsiniz.</p>
            <p>Admin olan kullanıcılar tüm projeleri düzenleyebilir. Diğer kullanıcılar sadece kendi projelerini düzenleyebilirler.</p>
            <p>İptal edilen projeler düzenlenemez düzenleyebilmek için admin tarafından tekrar oylama aşamasına alınmaları gerekir.</p>

            <h3 style="color:#660066;">Proje Anketi:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/project_vote.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-edit fa-lg"></i> butonuna basınca açılan sayfada "Etkilenen Birim Onaylarını" "Admin" olarak görebilirsiniz. Birim onaylarını sadece ilgili "Birim Yönetici" verebilir. </p>
            <p><i style="color: black;" class="fa fa-cog fa-lg"></i> butonuna basınca açılan sayfada "Proje Değerelendirme Anketine" soru ekleyebilir,soru kaldırabilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-check fa-lg"></i> butonuna basınca açılan sayfada "Proje Değerelendirme Anketini" doldurarak projeyi oylayabilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-filter fa-sm"></i> butonuna basınca açılan sayfada "Proje Durumu" ve "Yorum Kısmını" doldurarak projeyi filtreleyerek durumunu değiştirebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>
            <br/>
            <h3 style="color:#660066;">Proje Anket Sonucu:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/project_report.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Değerlendirme Anketinin" oylanma oranını görebilirsiniz.</p>
            <br/>
            <h3 style="color:#660066;">Devam Eden Projeler:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/project_contiunes.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-list fa-lg"></i> butonuna basınca açılan sayfada özet proje bilgisi ile "Çalışma Alanı" ve "Çalışma Takımı" sayfalarına giden butonlar bulunur. </i></p>
            <p><i style="color: black;" class="fa fa-filter fa-sm"></i> butonuna basınca açılan sayfada "Proje Durumu" ve "Yorum Kısmını" doldurarak projeyi filtreleyerek durumunu değiştirebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>
            <br/>
            
            <h3 style="color:#660066;">Tamamlanan Projeler:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/project_complated.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-list fa-lg"></i> butonuna basınca açılan sayfada özet proje bilgisi ile "Çalışma Alanı" ve "Çalışma Takımı" sayfalarına giden butonlar bulunur. </i></p>
            <p><i style="color: black;" class="fa fa-filter fa-sm"></i> butonuna basınca açılan sayfada "Proje Durumu" ve "Yorum Kısmını" doldurarak projeyi filtreleyerek durumunu değiştirebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>
            <br/>
            <h3 style="color:#660066;">İptal Edilen Projeler:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/project_cancelled.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-list fa-lg"></i> butonuna basınca açılan sayfada özet proje bilgisi ile "Çalışma Alanı" ve "Çalışma Takımı" sayfalarına giden butonlar bulunur. </i></p>
            <p><i style="color: black;" class="fa fa-filter fa-sm"></i> butonuna basınca açılan sayfada "Proje Durumu" ve "Yorum Kısmını" doldurarak projeyi filtreleyerek durumunu değiştirebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>
            <br/>

            
        @endif



        <!-- Staff User Guide -->
        @if(Auth::user()->privilege_id == 2)
            <h3 style="color:#660066;">"Personel Kullanıcısı" İçin Kullanım Kılavuzu:</h3><br/>

            <h3 style="color:#660066;">Proje Formu:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/staff_user_guide/project_forms.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna tıklayarak "Proje Formuna" erişebilirsiniz.</p>
            <p>Proje fikirlerinizi "Proje Formunu" doldurarak gönderebilirsiniz. Projeden "Etkilenen Birimler" projeyi onaylarsa projeniz oylamaya açılacaktır.</p><br/>
            <br/>
            <h3 style="color:#660066;">Proje Düzenle:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/staff_user_guide/project_edit.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan "Proje Düzenleme Sayfası" ile projelerinizi güncelleyebilirsiniz. soru ve mevcut süreçler ekleyebilir,soruları kaldırabilirsiniz.</p>
            <p>Admin olan kullanıcılar tüm projeleri düzenleyebilir. Diğer kullanıcılar sadece kendi projelerini düzenleyebilirler.</p>
            <p>İptal edilen projeler düzenlenemez düzenleyebilmek için admin tarafından tekrar oylama aşamasına alınmaları gerekir.</p>
            <h3 style="color:#660066;">Proje Anketi:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/staff_user_guide/project_vote.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-check fa-lg"></i> butonuna basınca açılan sayfada "Proje Değerelendirme Anketini" doldurarak projeyi oylayabilirsiniz.</p><br/>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>

            <h3 style="color:#660066;">Proje Anket Sonucu:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/staff_user_guide/project_report.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Değerlendirme Anketinin" oylanma oranını görebilirsiniz.</p><br/>
            <h3 style="color:#660066;">Devam Eden Projeler:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/staff_user_guide/project_contiunes.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-list fa-lg"></i> butonuna basınca açılan sayfada özet proje bilgisi ile "Çalışma Alanı" ve "Çalışma Takımı" sayfalarına giden butonlar bulunur. </i></p>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>
            <br/>
            
            <h3 style="color:#660066;">Tamamlanan Projeler:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/staff_user_guide/project_complated.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-list fa-lg"></i> butonuna basınca açılan sayfada özet proje bilgisi ile "Çalışma Alanı" ve "Çalışma Takımı" sayfalarına giden butonlar bulunur. </i></p>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>
            <br/>
            <h3 style="color:#660066;">İptal Edilen Projeler:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/staff_user_guide/project_cancelled.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-list fa-lg"></i> butonuna basınca açılan sayfada özet proje bilgisi ile "Çalışma Alanı" ve "Çalışma Takımı" sayfalarına giden butonlar bulunur. </i></p>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>
        
        @endif


        <!-- Subscriber (Manager) User Guide -->
        @if(Auth::user()->privilege_id == 3)
            <h3 style="color:#660066;">"Yönetici Kullanıcısı" İçin Kullanım Kılavuzu:</h3><br/>
            <h3 style="color:#660066;">Proje Formu:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/subscriber_user_guide/project_forms.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna tıklayarak "Proje Formuna" erişebilirsiniz.</p>
            <p>Proje fikirlerinizi "Proje Formunu" doldurarak gönderebilirsiniz. Projeden "Etkilenen Birimler" projeyi onaylarsa projeniz oylamaya açılacaktır.</p><br/>
            <br/>
            <h3 style="color:#660066;">Proje Düzenle:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/subscriber_user_guide/project_edit.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan "Proje Düzenleme Sayfası" ile projelerinizi güncelleyebilirsiniz. soru ve mevcut süreçler ekleyebilir,soruları kaldırabilirsiniz.</p>
            <p>Admin olan kullanıcılar tüm projeleri düzenleyebilir. Diğer kullanıcılar sadece kendi projelerini düzenleyebilirler.</p>
            <p>İptal edilen projeler düzenlenemez düzenleyebilmek için admin tarafından tekrar oylama aşamasına alınmaları gerekir.</p>
            <h3 style="color:#660066;">Proje Anketi:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/subscriber_user_guide/project_vote.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-check fa-lg"></i> butonuna basınca açılan sayfada "Proje Değerelendirme Anketini" doldurarak projeyi oylayabilirsiniz.</p><br/>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>

            <h3 style="color:#660066;">Proje Anket Sonucu:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/subscriber_user_guide/project_report.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Değerlendirme Anketinin" oylanma oranını görebilirsiniz.</p><br/>
            <h3 style="color:#660066;">Devam Eden Projeler:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/subscriber_user_guide/project_contiunes.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-list fa-lg"></i> butonuna basınca açılan sayfada özet proje bilgisi ile "Çalışma Alanı" ve "Çalışma Takımı" sayfalarına giden butonlar bulunur. </i></p>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>
            <br/>
            
            <h3 style="color:#660066;">Tamamlanan Projeler:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/subscriber_user_guide/project_complated.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-list fa-lg"></i> butonuna basınca açılan sayfada özet proje bilgisi ile "Çalışma Alanı" ve "Çalışma Takımı" sayfalarına giden butonlar bulunur. </i></p>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>
            <br/>
            <h3 style="color:#660066;">İptal Edilen Projeler:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/subscriber_user_guide/project_cancelled.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-list fa-lg"></i> butonuna basınca açılan sayfada özet proje bilgisi ile "Çalışma Alanı" ve "Çalışma Takımı" sayfalarına giden butonlar bulunur. </i></p>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>
        
        @endif


        <!-- UnitSubscriber (Unit Manager) User Guide -->
        @if(Auth::user()->privilege_id == 4)
            <h3 style="color:#660066;">"Birim Yönetici Kullanıcısı" İçin Kullanım Kılavuzu:</h3><br/>
            <h3 style="color:#660066;">Proje Formu:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/unit_subscriber_user_guide/project_forms.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna tıklayarak "Proje Formuna" erişebilirsiniz.</p>
            <p>Proje fikirlerinizi "Proje Formunu" doldurarak gönderebilirsiniz. Projeden "Etkilenen Birimler" projeyi onaylarsa projeniz oylamaya açılacaktır.</p><br/>
            <br/>
            <h3 style="color:#660066;">Proje Düzenle:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/unit_subscriber_user_guide/project_edit.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan "Proje Düzenleme Sayfası" ile projelerinizi güncelleyebilirsiniz. soru ve mevcut süreçler ekleyebilir,soruları kaldırabilirsiniz.</p>
            <p>Admin olan kullanıcılar tüm projeleri düzenleyebilir. Diğer kullanıcılar sadece kendi projelerini düzenleyebilirler.</p>
            <p>İptal edilen projeler düzenlenemez düzenleyebilmek için admin tarafından tekrar oylama aşamasına alınmaları gerekir.</p>
            <h3 style="color:#660066;">Proje Anketi:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/unit_subscriber_user_guide/project_vote.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-edit fa-lg"></i> butonuna basınca açılan sayfada "Etkilenen Birim Onaylarını" "Birim Yöneticisi" olarak görebilirsiniz. Birim onaylarını sadece ilgili "Birim Yönetici" verebilir. </p>
            <p><i style="color: black;" class="fa fa-check fa-lg"></i> butonuna basınca açılan sayfada "Proje Değerelendirme Anketini" doldurarak projeyi oylayabilirsiniz.</p><br/>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>

            <h3 style="color:#660066;">Proje Anket Sonucu:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/unit_subscriber_user_guide/project_report.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Değerlendirme Anketinin" oylanma oranını görebilirsiniz.</p><br/>
            <h3 style="color:#660066;">Devam Eden Projeler:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/unit_subscriber_user_guide/project_contiunes.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-list fa-lg"></i> butonuna basınca açılan sayfada özet proje bilgisi ile "Çalışma Alanı" ve "Çalışma Takımı" sayfalarına giden butonlar bulunur. </i></p>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>
            <br/>
            <h3 style="color:#660066;">Tamamlanan Projeler:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/unit_subscriber_user_guide/project_complated.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-list fa-lg"></i> butonuna basınca açılan sayfada özet proje bilgisi ile "Çalışma Alanı" ve "Çalışma Takımı" sayfalarına giden butonlar bulunur. </i></p>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>
            <br/>
            <h3 style="color:#660066;">İptal Edilen Projeler:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/unit_subscriber_user_guide/project_cancelled.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-list fa-lg"></i> butonuna basınca açılan sayfada özet proje bilgisi ile "Çalışma Alanı" ve "Çalışma Takımı" sayfalarına giden butonlar bulunur. </i></p>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>
        @endif


        <!-- Developer User Guide -->
        @if(Auth::user()->privilege_id == 5)
            <h3 style="color:#660066;">"Developer" İçin Kullanım Kılavuzu:</h3><br/>

            <h3 style="color:#660066;">Devam Eden Projeler:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/developer_user_guide/project_contiunes.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-list fa-lg"></i> butonuna basınca açılan sayfada özet proje bilgisi ile "Çalışma Alanı" ve "Çalışma Takımı" sayfalarına giden butonlar bulunur. </i></p>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>
            <br/>
            <h3 style="color:#660066;">Tamamlanan Projeler:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/developer_user_guide/project_complated.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-list fa-lg"></i> butonuna basınca açılan sayfada özet proje bilgisi ile "Çalışma Alanı" ve "Çalışma Takımı" sayfalarına giden butonlar bulunur. </i></p>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>
            <br/>
            <h3 style="color:#660066;">İptal Edilen Projeler:</h3>
            <div class="col-4"><img src="{{ asset('assets/img/developer_user_guide/project_cancelled.png') }}" alt=""></div>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-list fa-lg"></i> butonuna basınca açılan sayfada özet proje bilgisi ile "Çalışma Alanı" ve "Çalışma Takımı" sayfalarına giden butonlar bulunur. </i></p>
            <p><i style="color: black;" class="fa fa-comment fa-sm"></i> butonuna basınca açılan sayfada proje için yorum yazabileceğiniz "Yorum Alanı" ve  "Proje Durumu" için yapılan filtreleme işlemlerinin kayıtlarını görebilirsiniz. burada işlemi,işlemi yapan kişiyi,yorumunu,işlem tarihini görebilirsiniz.</p>

        @endif
       
    </div>

</div>

@endsection