@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    @if(count($sublinks) > 0)
                    @foreach($sublinks as $index => $value)
                        @if($index == 0)
                            <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li> 
                        @else
                        <li><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li>
                        @endif
                    @endforeach
                    @else
                        <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($sublink_name))}}">{{$sublink_name}}</a></li> 
                    @endif
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    @if(count($sublinks) > 0)
                    @foreach($sublinks as $index => $value)
                        @if($index == 0)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade in active">
                            <h1>hello</h1>
                        </div>
                        @else
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                            <h1>hello</h1>
                        </div>
                        @endif
                    @endforeach
                    @else
                        <div id="{{str_replace(' ','-',strtolower($sublink_name))}}" class="tab-pane fade in active">
                           <div class="row">
                               <div class="col-sm-12">
                                   <table class="table table-stripped table-bordered">
                                       <thead>
                                           <tr>
                                               <th>Category</th>
                                               <th>Description</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                        <tr><td>Adult goods and services</td><td>Adult goods and services which includes pornography and other sexually suggestive materials (including literature, imagery and other media); escort or prostitution services. Apparatus such as personal massagers/vibrators and sex toys and enhancements.</td></tr>
                                        <tr><td>Alcohol</td><td>Alcohol, which includes Alcohol or alcoholic beverages such as beer, liquor, wine, or champagne.</td></tr>
                                        <tr><td>Body parts</td><td>Body parts, which includes organs or other body parts – live, cultured/preserved or from cadaver.</td></tr>
                                        <tr><td>Bulk marketing tools</td><td>Bulk marketing tools which include email lists, software, or other products enabling unsolicited email messages (spam).</td></tr>
                                        <tr><td>Cable TV descramblers and black boxes</td><td>Cable TV descramblers and black boxes which include devices intended to obtain cable and satellite signals for free.</td></tr>
                                        <tr><td>Child pornography</td><td>Child pornography in any form.</td></tr>
                                        <tr><td>Copyright unlocking devices</td><td>Copyright unlocking devices which includes Mod chips or other devices designed to circumvent copyright protection.</td></tr>
                                        <tr><td>Copyrighted media</td><td>Copyrighted media, which includes unauthorized copies of books, music, movies, and other licensed or protected materials.</td></tr>
                                        <tr><td>Copyrighted software</td><td>Copyrighted software which includes unauthorized copies of software, video games and other licensed or protected materials, including OEM or bundled software.</td></tr>
                                        <tr><td>Counterfeit and unauthorized goods</td><td>Counterfeit and unauthorized goods which includes replicas or imitations of designer goods; items without a celebrity endorsement that would normally require such an association; fake autographs, counterfeit stamps, and other potentially unauthorized goods.</td></tr>
                                        <tr><td>Drugs and drug paraphernalia</td><td>Drugs and drug paraphernalia which includes illegal drugs and drug accessories, including herbal drugs including but not limited to salvia and magic mushrooms.</td></tr>
                                        <tr><td>Drug test circumvention aids</td><td>Drug test circumvention aids which includes drug cleansing shakes, urine test additives, and related items.</td></tr>
                                        <tr><td>Endangered species</td><td>Endangered species, which includes plants, animals or other organisms (including product derivatives) in danger of extinction.</td></tr>
                                        <tr><td>Gaming/gambling</td><td>Gaming/gambling which includes lottery tickets, sports bets, memberships/ enrolment in online gambling sites, and related content.</td></tr>
                                        <tr><td>Government IDs or documents</td><td>Government IDs or documents which includes fake IDs, passports, diplomas, and noble titles.</td></tr>
                                        <tr><td>Hacking and cracking materials</td><td>Hacking and cracking materials which include manuals, how-to guides, information, or equipment enabling illegal access to software, servers, websites, or other protected property.</td></tr>
                                        <tr><td>Illegal goods</td><td>Illegal goods which includes materials, products, or information promoting illegal goods or enabling illegal acts.</td></tr>
                                        <tr><td>Miracle cures</td><td>Miracle cures which include unsubstantiated cures, remedies or other items marketed as quick health fixes.</td></tr>
                                        <tr><td>Offensive goods</td><td>Offensive goods which includes literature, products or other materials that: (a) Defame or slander any person or groups of people based on race, ethnicity, national origin, religion, sex, or other factors; (b) Encourage or incite violent acts; and (c) Promote intolerance or hatred. (e) crime which includes crime scene photos or items, such as personal belongings, associated with criminals</td></tr>
                                        <tr><td>Prescription drugs or herbal drugs or any kind of online pharmacies</td><td>Prescription drugs or herbal drugs or any kind of online pharmacies which includes drugs or other products requiring a prescription by a recognized and licensed medical practitioner in India or anywhere else.</td></tr>
                                        <tr><td>Pyrotechnic devices and hazardous materials</td><td>Pyrotechnic devices and hazardous materials which includes fireworks and related goods; toxic, flammable, and radioactive materials and substances.</td></tr>
                                        <tr><td>Regulated goods</td><td>Regulated goods which includes air bags; batteries containing mercury; Freon or similar substances/refrigerants; chemical/industrial solvents; government uniforms; car titles; license plates; police badges and law enforcement equipment; lock-picking devices; pesticides; postage meters; recalled items; slot machines; surveillance equipment; goods regulated by government or other agency specifications.</td></tr>
                                        <tr><td>Securities</td><td>Securities, which includes stocks, bonds, mutual funds or related financial products or investments.</td></tr>
                                        <tr><td>Tobacco and cigarettes</td><td>Tobacco and cigarettes which includes cigarettes, cigars, chewing tobacco, and related products.</td></tr>
                                        <tr><td>Traffic devices</td><td>Traffic devices, which includes radar detectors/ jammers, license plate covers, traffic signal changers, and related products.</td></tr>
                                        <tr><td>Weapons</td><td>Weapons, which includes firearms, ammunition, knives, brass knuckles, gun parts, and other armaments.</td></tr>
                                        <tr><td>Wholesale currency</td><td>Wholesale currency, which includes discounted currencies or currency, exchanges including Crypto currencies.</td></tr>
                                        <tr><td>Live animals</td><td>Live animals or hides/skins/teeth, nails and other parts etc of animals.</td></tr>
                                        <tr><td>Marketing schemes</td><td>Multi-level Marketing schemes or Pyramid/Matrix sites or websites using a matrix scheme approach.</td></tr>
                                        <tr><td>Intangible goods</td><td>Any intangible goods or services or aggregation/consolidation business.</td></tr>
                                        <tr><td>Work-at-home</td><td>Work-at-home information.</td></tr>
                                        <tr><td>Drop-shipped</td><td>Drop-shipped merchandise</td></tr>
                                        <tr><td>Web-based services</td><td>Web-based telephony/ SMS/Text/Facsimile services or Calling Cards. Bandwidth or Data transfer/ allied services. Voice process /knowledge process services.</td></tr>
                                        <tr><td>Any product or service</td><td>Any product or service, which is not in compliance with all applicable laws and regulations whether federal, state, both local and international, including the laws of India.</td></tr>
                                       </tbody>
                                   </table>
                               </div>
                           </div>                          
                        </div>
                    @endif
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection
