<div class="col-sm-12">
    @switch($bussiness_id)
    @case(1)
        <div>
            <div class="text-center color-red">
                Note:Pdfs & Images are only allowed up to 5mb in size
            </div>
            <div id="ajax-activate-account-success" class="text-center"></div>
            <div id="ajax-activate-account-failed" class="text-center text-danger"></div>
            <div id="ajax-activate-account-uploaded" class="text-center text-success"></div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="comp_pan_card">Company Pancard: <span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="comp_pan_card" id="file-1" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-1" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="comp_pan_card_file">
                                @if(!empty($docs_list->comp_pan_card))
                                <span id="comp_pan_card_file_exist">{{$docs_list->comp_pan_card}}</span>
                                @else
                                <span id="comp_pan_card_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                        </label>
                        @if(!empty($docs_list->comp_pan_card))
                        <button type="reset" class="button124" data-name="comp_pan_card" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button>
                        @endif
                        <div id="comp_pan_card_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->comp_pan_card))
                            <a href="/download/merchant-document/{{$docs_list->comp_pan_card}}" >{{$docs_list->comp_pan_card}}</a>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="comp_gst_doc">Company GST:</label>
                    <div class="col-sm-4">
                        <input type="file" name="comp_gst_doc" id="file-2" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        
                        <label for="file-2" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                            <span id="comp_gst_doc_file">
                                @if(!empty($docs_list->comp_gst_doc))
                                <span id="comp_gst_doc_file_exist">{{$docs_list->comp_gst_doc}}</span>
                                @else
                                <span id="comp_gst_doc_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                        </label>
                        @if(!empty($docs_list->comp_gst_doc))               
                        <button class="button124" data-name="comp_gst_doc" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button>
                        @endif
                        <div id="comp_gst_doc_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->comp_gst_doc))
                            <a href="/download/merchant-document/{{$docs_list->comp_gst_doc}}">{{$docs_list->comp_gst_doc}}</a>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="bank_statement">Bank statement:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="bank_statement" id="file-3" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-3" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                                    <span id="bank_statement_file">
                                    @if(!empty($docs_list->bank_statement))
                                        <span id="bank_statement_file_exist">{{$docs_list->bank_statement}}</span>
                                    @else
                                    <span id="bank_statement_file_not_exist">Choose a file...</span>
                                    @endif
                                </span>
                            </label>
                        @if(!empty($docs_list->bank_statement))
                        <button class="button124" data-name="bank_statement" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button>
                        @endif
                        <div id="bank_statement_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->bank_statement))
                            <a href="/download/merchant-document/{{$docs_list->bank_statement}}">{{$docs_list->bank_statement}}</a>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="cancel_cheque">Cancel cheque:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="cancel_cheque" id="file-4" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple/>
                        <label for="file-4" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                                    <span id="cancel_cheque_file">
                                    @if(!empty($docs_list->cancel_cheque))
                                    <span id="cancel_cheque_file_exist">{{$docs_list->cancel_cheque}}</span>
                                    @else
                                    <span id="cancel_cheque_file_not_exist">Choose a file...</span>
                                    @endif
                                </span>
                            </label>
                        @if(!empty($docs_list->cancel_cheque))
                        <button class="button124" data-name="cancel_cheque" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button>
                        @endif
                        <div id="cancel_cheque_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->cancel_cheque))
                            <a href="/download/merchant-document/{{$docs_list->cancel_cheque}}">{{$docs_list->cancel_cheque}}</a>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="cin_doc">Certificate of Incorporation:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="cin_doc" id="file-5" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-5" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                                    <span id="cin_doc_file">
                                    @if(!empty($docs_list->cin_doc))
                                    <span id="cin_doc_file_exist">{{$docs_list->cin_doc}}</span>
                                    @else
                                    <span id="cin_doc_file_not_exist">Choose a file...</span>
                                    @endif
                                </span>
                            </label>
                        @if(!empty($docs_list->cin_doc))
                        <button class="button124" data-name="cin_doc" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button>
                        @endif
                        <div id="cin_doc_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->cin_doc))
                            <a href="/download/merchant-document/{{$docs_list->cin_doc}}">{{$docs_list->cin_doc}}</a>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="moa_doc">MOA:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">

                        <input type="file" name="moa_doc" id="file-6" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-6" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                                <span id="moa_doc_file">
                                    @if(!empty($docs_list->moa_doc))
                                    <span id="moa_doc_file_exist">{{$docs_list->moa_doc}}</span>
                                    @else
                                    <span id="moa_doc_file_not_exist">Choose a file...</span>
                                    @endif
                            </span>
                        </label>
                        @if(!empty($docs_list->moa_doc))
                        <button class="button124" data-name="moa_doc" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button> 
                        @endif                             
                        <div id="moa_doc_error"></div>
                        
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->moa_doc))
                            <a href="/download/merchant-document/{{$docs_list->moa_doc}}">{{$docs_list->moa_doc}}</a>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="aoa_doc">AOA:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">

                        <input type="file" name="aoa_doc" id="file-7" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-7" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                                <span id="aoa_doc_file">
                                    @if(!empty($docs_list->aoa_doc))
                                    <span id="aoa_doc_file_exist">{{$docs_list->aoa_doc}}</span>
                                    @else
                                    <span id="aoa_doc_file_not_exist">Choose a file...</span>
                                    @endif
                            </span>
                        </label>
                        @if(!empty($docs_list->aoa_doc))
                        <button class="button124" data-name="aoa_doc" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button> 
                        @endif                             
                        <div id="aoa_doc_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->aoa_doc))
                            <a href="/download/merchant-document/{{$docs_list->aoa_doc}}">{{$docs_list->aoa_doc}}</a>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="mer_pan_card">Authorized Signatory Pancard:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">

                        <input type="file" name="mer_pan_card" id="file-8" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-8" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                            <span id="mer_pan_card_file">
                                @if(!empty($docs_list->mer_pan_card))
                                <span id="mer_pan_card_file_exist">{{$docs_list->mer_pan_card}}</span>
                                @else
                                <span id="mer_pan_card_file_not_exist">Choose a file...</span>
                                @endif
                        </span>
                        </label>
                        @if(!empty($docs_list->mer_pan_card))
                        <button class="button124" data-name="mer_pan_card" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button> 
                        @endif                            
                        <div id="mer_pan_card_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->mer_pan_card))
                            <a href="/download/merchant-document/{{$docs_list->mer_pan_card}}">{{$docs_list->mer_pan_card}}</a>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="mer_aadhar_card">Authorized Signatory Aadhar Card:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">

                        <input type="file" name="mer_aadhar_card" id="file-9" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-9" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                            <span id="mer_aadhar_card_file">
                                @if(!empty($docs_list->mer_aadhar_card))
                                <span id="mer_aadhar_card_file_exist">{{$docs_list->mer_aadhar_card}}</span>
                                @else
                                <span id="mer_aadhar_card_file_not_exist">Choose a file...</span>
                                @endif
                        </span>
                        </label>           
                        @if(!empty($docs_list->mer_aadhar_card))
                        <button class="button124" data-name="mer_aadhar_card" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button> 
                        @endif 
                        <div id="mer_aadhar_card_error"></div>
                
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->mer_aadhar_card))
                            <a href="/download/merchant-document/{{$docs_list->mer_aadhar_card}}">{{$docs_list->mer_aadhar_card}}</a>
                        @endif
                    </div>
                </div>
                <input type="hidden" name="id" id="id" value="{{!empty($docs_list->id)?$docs_list->id:''}}">
            </div>
        </div>
        @break
    @case(2)
        <div>
            <div class="text-center color-red">
                Note:Pdfs & Images are only allowed up to 5mb in size
            </div>
            <div id="ajax-activate-account-failed" class="text-center color-red"></div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="mer_pan_card">Authorized Signatory Pancard:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="mer_pan_card" id="file-1" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="comp_pan_card_file">
                                @if(!empty($docs_list->mer_pan_card))
                                <span id="comp_pan_card_file_exist">{{$docs_list->mer_pan_card}}</span>
                                @else
                                <span id="comp_pan_card_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                       </label>
                       @if(!empty($docs_list->mer_pan_card))
                       <button type="reset" class="button124" data-name="mer_pan_card" data-id="{{$docs_list->id}}">
                           <i class="fa fa-times"></i>
                       </button>
                       @endif
                       <div id="mer_pan_card_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->mer_pan_card))
                        <a href="/download/merchant-document/{{$docs_list->mer_pan_card}}">{{$docs_list->mer_pan_card}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="mer_aadhar_card">Authorized Signatory Aadhar Card:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="mer_aadhar_card" id="file-2" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="mer_aadhar_card_file">
                                @if(!empty($docs_list->mer_aadhar_card))
                                <span id="mer_aadhar_card_file_exist">{{$docs_list->mer_aadhar_card}}</span>
                                @else
                                <span id="mer_aadhar_card_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                       </label>
                       @if(!empty($docs_list->mer_aadhar_card))
                       <button type="reset" class="button124" data-name="mer_aadhar_card" data-id="{{$docs_list->id}}">
                           <i class="fa fa-times"></i>
                       </button>
                       @endif
                       <div id="mer_aadhar_card_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->mer_aadhar_card))
                        <a href="/download/merchant-document/{{$docs_list->mer_aadhar_card}}">{{$docs_list->mer_aadhar_card}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="comp_gst_doc">Company GST:</label>
                    <div class="col-sm-4">
                        <input type="file" name="comp_gst_doc" id="file-3" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="comp_gst_doc_file">
                                @if(!empty($docs_list->comp_gst_doc))
                                <span id="comp_gst_doc_file_exist">{{$docs_list->comp_gst_doc}}</span>
                                @else
                                <span id="comp_gst_doc_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                       </label>
                       @if(!empty($docs_list->comp_gst_doc))
                       <button type="reset" class="button124" data-name="comp_gst_doc" data-id="{{$docs_list->id}}">
                           <i class="fa fa-times"></i>
                       </button>
                       @endif
                       <div id="comp_gst_doc_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->comp_gst_doc))
                        <a href="/download/merchant-document/{{$docs_list->comp_gst_doc}}">{{$docs_list->comp_gst_doc}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="bank_statement">Bank statement:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">                 
                        
                        <input type="file" name="bank_statement" id="file-5" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="bank_statement_file">
                                @if(!empty($docs_list->bank_statement))
                                <span id="bank_statement_file_exist">{{$docs_list->bank_statement}}</span>
                                @else
                                <span id="bank_statement_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                       </label>
                       @if(!empty($docs_list->bank_statement))
                       <button type="reset" class="button124" data-name="bank_statement" data-id="{{$docs_list->id}}">
                           <i class="fa fa-times"></i>
                       </button>
                       @endif
                       <div id="bank_statement_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->bank_statement))
                        <a href="/download/merchant-document/{{$docs_list->bank_statement}}">{{$docs_list->bank_statement}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="cancel_cheque">Cancel Cheque:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">                 
                        
                        <input type="file" name="cancel_cheque" id="file-6" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="cancel_cheque_file">
                                @if(!empty($docs_list->cancel_cheque))
                                <span id="cancel_cheque_file_exist">{{$docs_list->cancel_cheque}}</span>
                                @else
                                <span id="cancel_cheque_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                       </label>
                       @if(!empty($docs_list->cancel_cheque))
                       <button type="reset" class="button124" data-name="cancel_cheque" data-id="{{$docs_list->id}}">
                           <i class="fa fa-times"></i>
                       </button>
                       @endif
                       <div id="cancel_cheque_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->cancel_cheque))
                        <a href="/download/merchant-document/{{$docs_list->cancel_cheque}}">{{$docs_list->cancel_cheque}}</a>
                        @endif   
                    </div>
                </div>
                <input type="hidden" name="id" id="id" value="{{!empty($docs_list->id)?$docs_list->id:''}}">
            </div>
        </div>
        @break
    @case(3)
        <div>
            <div class="text-center color-red">
                Note:Pdfs & Images are only allowed up to 5mb in size
            </div>
            <div id="ajax-activate-account-failed" class="text-center color-red"></div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="comp_pan_card">Company Pancard:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="comp_pan_card" id="file-1" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-1" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="comp_pan_card_file">
                                @if(!empty($docs_list->comp_pan_card))
                                <span id="comp_pan_card_file_exist">{{$docs_list->comp_pan_card}}</span>
                                @else
                                <span id="comp_pan_card_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                        @if(!empty($docs_list->comp_pan_card))
                        <button type="reset" class="button124" data-name="comp_pan_card" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button>
                        @endif
                        <div id="comp_pan_card_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->comp_pan_card))
                            <a href="/download/merchant-document/{{$docs_list->comp_pan_card}}" >{{$docs_list->comp_pan_card}}</a>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="comp_gst_doc">Company GST:</label>
                    <div class="col-sm-4">
                        <input type="file" name="comp_gst_doc" id="file-2" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-2" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="comp_gst_doc_file">
                                @if(!empty($docs_list->comp_gst_doc))
                                <span id="comp_gst_doc_file_exist">{{$docs_list->comp_gst_doc}}</span>
                                @else
                                <span id="comp_gst_doc_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                    @if(!empty($docs_list->comp_gst_doc))
                    <button type="reset" class="button124" data-name="comp_gst_doc" data-id="{{$docs_list->id}}">
                        <i class="fa fa-times"></i>
                    </button>
                    @endif
                    <div id="comp_gst_doc_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->comp_gst_doc))
                        <a href="/download/merchant-document/{{$docs_list->comp_gst_doc}}">{{$docs_list->comp_gst_doc}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="mer_pan_card">Authorized Signatory Pancard:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="mer_pan_card" id="file-3" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-3" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="mer_pan_card_file">
                                @if(!empty($docs_list->mer_pan_card))
                                <span id="mer_pan_card_file_exist">{{$docs_list->mer_pan_card}}</span>
                                @else
                                <span id="mer_pan_card_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                    @if(!empty($docs_list->mer_pan_card))
                    <button type="reset" class="button124" data-name="mer_pan_card" data-id="{{$docs_list->id}}">
                        <i class="fa fa-times"></i>
                    </button>
                    @endif
                    <div id="mer_pan_card_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->mer_pan_card))
                        <a href="/download/merchant-document/{{$docs_list->mer_pan_card}}">{{$docs_list->mer_pan_card}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="mer_aadhar_card">Authorized Signatory Aadhar Card:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="mer_aadhar_card" id="file-4" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-4" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="mer_aadhar_card_file">
                                @if(!empty($docs_list->mer_aadhar_card))
                                <span id="mer_aadhar_card_file_exist">{{$docs_list->mer_aadhar_card}}</span>
                                @else
                                <span id="mer_aadhar_card_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                    @if(!empty($docs_list->mer_aadhar_card))
                    <button type="reset" class="button124" data-name="mer_aadhar_card" data-id="{{$docs_list->id}}">
                        <i class="fa fa-times"></i>
                    </button>
                    @endif
                    <div id="mer_aadhar_card_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->mer_aadhar_card))
                        <a href="/download/merchant-document/{{$docs_list->mer_aadhar_card}}">{{$docs_list->mer_aadhar_card}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="partnership_deed">Partnership Deed:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="partnership_deed" id="file-5" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-5" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="partnership_deed_file">
                                @if(!empty($docs_list->partnership_deed))
                                <span id="partnership_deed_file_exist">{{$docs_list->partnership_deed}}</span>
                                @else
                                <span id="partnership_deed_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                    @if(!empty($docs_list->partnership_deed))
                    <button type="reset" class="button124" data-name="partnership_deed" data-id="{{$docs_list->id}}">
                        <i class="fa fa-times"></i>
                    </button>
                    @endif
                    <div id="partnership_deed_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->partnership_deed))
                        <a href="/download/merchant-document/{{$docs_list->partnership_deed}}">{{$docs_list->partnership_deed}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="bank_statement">Bank statement:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">                 
                        
                        <input type="file" name="bank_statement" id="file-7" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-7" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="bank_statement_file">
                                @if(!empty($docs_list->bank_statement))
                                <span id="bank_statement_file_exist">{{$docs_list->bank_statement}}</span>
                                @else
                                <span id="bank_statement_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                    @if(!empty($docs_list->bank_statement))
                    <button type="reset" class="button124" data-name="bank_statement" data-id="{{$docs_list->id}}">
                        <i class="fa fa-times"></i>
                    </button>
                    @endif
                    <div id="bank_statement_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->bank_statement))
                        <a href="/download/merchant-document/{{$docs_list->bank_statement}}">{{$docs_list->bank_statement}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="cancel_cheque">Cancel Cheque:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">                 
                        
                        <input type="file" name="cancel_cheque" id="file-8" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-8" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="cancel_cheque_file">
                                @if(!empty($docs_list->cancel_cheque))
                                <span id="cancel_cheque_file_exist">{{$docs_list->cancel_cheque}}</span>
                                @else
                                <span id="cancel_cheque_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                    @if(!empty($docs_list->cancel_cheque))
                    <button type="reset" class="button124" data-name="cancel_cheque" data-id="{{$docs_list->id}}">
                        <i class="fa fa-times"></i>
                    </button>
                    @endif
                    <div id="cancel_cheque_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->cancel_cheque))
                        <a href="/download/merchant-document/{{$docs_list->cancel_cheque}}">{{$docs_list->cancel_cheque}}</a>
                        @endif   
                    </div>
                </div>
                <input type="hidden" name="id" id="id" value="{{!empty($docs_list->id)?$docs_list->id:''}}">
            </div>
        </div>
        @break
    @case(4)
        <div>
            <div class="text-center color-red">
                Note:Pdfs & Images are only allowed up to 5mb in size
            </div>
            <div id="ajax-activate-account-failed" class="text-center color-red"></div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="comp_pan_card">Company Pancard:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="comp_pan_card" id="file-1" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-1" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="comp_pan_card_file">
                                @if(!empty($docs_list->comp_pan_card))
                                <span id="comp_pan_card_file_exist">{{$docs_list->comp_pan_card}}</span>
                                @else
                                <span id="comp_pan_card_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                        @if(!empty($docs_list->comp_pan_card))
                        <button type="reset" class="button124" data-name="comp_pan_card" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button>
                        @endif
                        <div id="comp_pan_card_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->comp_pan_card))
                            <a href="/download/merchant-document/{{$docs_list->comp_pan_card}}" >{{$docs_list->comp_pan_card}}</a>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="comp_gst_doc">Company GST:</label>
                    <div class="col-sm-4">
                        <input type="file" name="comp_gst_doc" id="file-2" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-2" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="comp_gst_doc_file">
                                @if(!empty($docs_list->comp_gst_doc))
                                <span id="comp_gst_doc_file_exist">{{$docs_list->comp_gst_doc}}</span>
                                @else
                                <span id="comp_gst_doc_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                    @if(!empty($docs_list->comp_gst_doc))
                    <button type="reset" class="button124" data-name="comp_gst_doc" data-id="{{$docs_list->id}}">
                        <i class="fa fa-times"></i>
                    </button>
                    @endif
                    <div id="comp_gst_doc_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->comp_gst_doc))
                        <a href="/download/merchant-document/{{$docs_list->comp_gst_doc}}">{{$docs_list->comp_gst_doc}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="mer_pan_card">Authorized Signatory Pancard:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="mer_pan_card" id="file-3" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-3" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="mer_pan_card_file">
                                @if(!empty($docs_list->mer_pan_card))
                                <span id="mer_pan_card_file_exist">{{$docs_list->mer_pan_card}}</span>
                                @else
                                <span id="mer_pan_card_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                    @if(!empty($docs_list->mer_pan_card))
                    <button type="reset" class="button124" data-name="mer_pan_card" data-id="{{$docs_list->id}}">
                        <i class="fa fa-times"></i>
                    </button>
                    @endif
                    <div id="mer_pan_card_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->mer_pan_card))
                        <a href="/download/merchant-document/{{$docs_list->mer_pan_card}}">{{$docs_list->mer_pan_card}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="mer_aadhar_card">Authorized Signatory Aadhar Card:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="mer_aadhar_card" id="file-4" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-4" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="mer_aadhar_card_file">
                                @if(!empty($docs_list->mer_aadhar_card))
                                <span id="mer_aadhar_card_file_exist">{{$docs_list->mer_aadhar_card}}</span>
                                @else
                                <span id="mer_aadhar_card_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                    @if(!empty($docs_list->mer_aadhar_card))
                    <button type="reset" class="button124" data-name="mer_aadhar_card" data-id="{{$docs_list->id}}">
                        <i class="fa fa-times"></i>
                    </button>
                    @endif
                    <div id="mer_aadhar_card_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->mer_aadhar_card))
                        <a href="/download/merchant-document/{{$docs_list->mer_aadhar_card}}">{{$docs_list->mer_aadhar_card}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="cin_doc">Certificate of Incorporation:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="cin_doc" id="file-5" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-5" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                                    <span id="cin_doc_file">
                                    @if(!empty($docs_list->cin_doc))
                                    <span id="cin_doc_file_exist">{{$docs_list->cin_doc}}</span>
                                    @else
                                    <span id="cin_doc_file_not_exist">Choose a file...</span>
                                    @endif
                                </span>
                            </label>
                        @if(!empty($docs_list->cin_doc))
                        <button class="button124" data-name="cin_doc" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button>
                        @endif
                        <div id="cin_doc_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->cin_doc))
                            <a href="/download/merchant-document/{{$docs_list->cin_doc}}">{{$docs_list->cin_doc}}</a>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="bank_statement">Bank statement:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">                 
                        
                        <input type="file" name="bank_statement" id="file-7" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-7" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="bank_statement_file">
                                @if(!empty($docs_list->bank_statement))
                                <span id="bank_statement_file_exist">{{$docs_list->bank_statement}}</span>
                                @else
                                <span id="bank_statement_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                    @if(!empty($docs_list->bank_statement))
                    <button type="reset" class="button124" data-name="bank_statement" data-id="{{$docs_list->id}}">
                        <i class="fa fa-times"></i>
                    </button>
                    @endif
                    <div id="bank_statement_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->bank_statement))
                        <a href="/download/merchant-document/{{$docs_list->bank_statement}}">{{$docs_list->bank_statement}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="cancel_cheque">Cancel Cheque:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">                 
                        
                        <input type="file" name="cancel_cheque" id="file-8" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-8" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="cancel_cheque_file">
                                @if(!empty($docs_list->cancel_cheque))
                                <span id="cancel_cheque_file_exist">{{$docs_list->cancel_cheque}}</span>
                                @else
                                <span id="cancel_cheque_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                    @if(!empty($docs_list->cancel_cheque))
                    <button type="reset" class="button124" data-name="cancel_cheque" data-id="{{$docs_list->id}}">
                        <i class="fa fa-times"></i>
                    </button>
                    @endif
                    <div id="cancel_cheque_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->cancel_cheque))
                        <a href="/download/merchant-document/{{$docs_list->cancel_cheque}}">{{$docs_list->cancel_cheque}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="aoa_doc">AOA:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">

                        <input type="file" name="aoa_doc" id="file-9" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-9" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                                <span id="aoa_doc_file">
                                    @if(!empty($docs_list->aoa_doc))
                                    <span id="aoa_doc_file_exist">{{$docs_list->aoa_doc}}</span>
                                    @else
                                    <span id="aoa_doc_file_not_exist">Choose a file...</span>
                                    @endif
                            </span>
                        </label>
                        @if(!empty($docs_list->aoa_doc))
                        <button class="button124" data-name="aoa_doc" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button> 
                        @endif                             
                        <div id="aoa_doc_error"></div>
                        
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->aoa_doc))
                            <a href="/download/merchant-document/{{$docs_list->aoa_doc}}">{{$docs_list->aoa_doc}}</a>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="moa_doc">MOA:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">

                        <input type="file" name="moa_doc" id="file-10" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-10" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                                <span id="moa_doc_file">
                                    @if(!empty($docs_list->moa_doc))
                                    <span id="moa_doc_file_exist">{{$docs_list->moa_doc}}</span>
                                    @else
                                    <span id="moa_doc_file_not_exist">Choose a file...</span>
                                    @endif
                            </span>
                        </label>
                        @if(!empty($docs_list->moa_doc))
                        <button class="button124" data-name="moa_doc" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button> 
                        @endif                             
                        <div id="moa_doc_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->moa_doc))
                            <a href="/download/merchant-document/{{$docs_list->moa_doc}}">{{$docs_list->moa_doc}}</a>
                        @endif
                    </div>
                </div>
                <input type="hidden" name="id" id="id" value="{{!empty($docs_list->id)?$docs_list->id:''}}">
            </div>
        </div>
        @break 
    @case(5)
        <div>
            <div class="text-center color-red">
                Note:Pdfs & Images are only allowed up to 5mb in size
            </div>
            <div id="ajax-activate-account-failed" class="text-center color-red"></div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="comp_pan_card">Company Pancard:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="comp_pan_card" id="file-1" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-1" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="comp_pan_card_file">
                                @if(!empty($docs_list->comp_pan_card))
                                <span id="comp_pan_card_file_exist">{{$docs_list->comp_pan_card}}</span>
                                @else
                                <span id="comp_pan_card_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                        @if(!empty($docs_list->comp_pan_card))
                        <button type="reset" class="button124" data-name="comp_pan_card" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button>
                        @endif
                        <div id="comp_pan_card_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->comp_pan_card))
                            <a href="/download/merchant-document/{{$docs_list->comp_pan_card}}" >{{$docs_list->comp_pan_card}}</a>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="comp_gst_doc">Company GST:</label>
                    <div class="col-sm-4">
                        <input type="file" name="comp_gst_doc" id="file-2" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-2" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="comp_gst_doc_file">
                                @if(!empty($docs_list->comp_gst_doc))
                                <span id="comp_gst_doc_file_exist">{{$docs_list->comp_gst_doc}}</span>
                                @else
                                <span id="comp_gst_doc_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                    @if(!empty($docs_list->comp_gst_doc))
                    <button type="reset" class="button124" data-name="comp_gst_doc" data-id="{{$docs_list->id}}">
                        <i class="fa fa-times"></i>
                    </button>
                    @endif
                    <div id="comp_gst_doc_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->comp_gst_doc))
                        <a href="/download/merchant-document/{{$docs_list->comp_gst_doc}}">{{$docs_list->comp_gst_doc}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="mer_pan_card">Authorized Signatory Pancard:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="mer_pan_card" id="file-3" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-3" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="mer_pan_card_file">
                                @if(!empty($docs_list->mer_pan_card))
                                <span id="mer_pan_card_file_exist">{{$docs_list->mer_pan_card}}</span>
                                @else
                                <span id="mer_pan_card_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                    @if(!empty($docs_list->mer_pan_card))
                    <button type="reset" class="button124" data-name="mer_pan_card" data-id="{{$docs_list->id}}">
                        <i class="fa fa-times"></i>
                    </button>
                    @endif
                    <div id="mer_pan_card_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->mer_pan_card))
                        <a href="/download/merchant-document/{{$docs_list->mer_pan_card}}">{{$docs_list->mer_pan_card}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="mer_aadhar_card">Authorized Signatory Aadhar Card:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="mer_aadhar_card" id="file-4" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-4" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="mer_aadhar_card_file">
                                @if(!empty($docs_list->mer_aadhar_card))
                                <span id="mer_aadhar_card_file_exist">{{$docs_list->mer_aadhar_card}}</span>
                                @else
                                <span id="mer_aadhar_card_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                    @if(!empty($docs_list->mer_aadhar_card))
                    <button type="reset" class="button124" data-name="mer_aadhar_card" data-id="{{$docs_list->id}}">
                        <i class="fa fa-times"></i>
                    </button>
                    @endif
                    <div id="mer_aadhar_card_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->mer_aadhar_card))
                        <a href="/download/merchant-document/{{$docs_list->mer_aadhar_card}}">{{$docs_list->mer_aadhar_card}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="cin_doc">Certificate of Incorporation:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="cin_doc" id="file-5" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-5" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                                    <span id="cin_doc_file">
                                    @if(!empty($docs_list->cin_doc))
                                    <span id="cin_doc_file_exist">{{$docs_list->cin_doc}}</span>
                                    @else
                                    <span id="cin_doc_file_not_exist">Choose a file...</span>
                                    @endif
                                </span>
                            </label>
                        @if(!empty($docs_list->cin_doc))
                        <button class="button124" data-name="cin_doc" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button>
                        @endif
                        <div id="cin_doc_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->cin_doc))
                            <a href="/download/merchant-document/{{$docs_list->cin_doc}}">{{$docs_list->cin_doc}}</a>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="bank_statement">Bank statement:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">                 
                        
                        <input type="file" name="bank_statement" id="file-7" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-7" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="bank_statement_file">
                                @if(!empty($docs_list->bank_statement))
                                <span id="bank_statement_file_exist">{{$docs_list->bank_statement}}</span>
                                @else
                                <span id="bank_statement_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                    @if(!empty($docs_list->bank_statement))
                    <button type="reset" class="button124" data-name="bank_statement" data-id="{{$docs_list->id}}">
                        <i class="fa fa-times"></i>
                    </button>
                    @endif
                    <div id="bank_statement_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->bank_statement))
                        <a href="/download/merchant-document/{{$docs_list->bank_statement}}">{{$docs_list->bank_statement}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="cancel_cheque">Cancel Cheque:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">                 
                        
                        <input type="file" name="cancel_cheque" id="file-8" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-8" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="cancel_cheque_file">
                                @if(!empty($docs_list->cancel_cheque))
                                <span id="cancel_cheque_file_exist">{{$docs_list->cancel_cheque}}</span>
                                @else
                                <span id="cancel_cheque_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                    </label>
                    @if(!empty($docs_list->cancel_cheque))
                    <button type="reset" class="button124" data-name="cancel_cheque" data-id="{{$docs_list->id}}">
                        <i class="fa fa-times"></i>
                    </button>
                    @endif
                    <div id="cancel_cheque_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->cancel_cheque))
                        <a href="/download/merchant-document/{{$docs_list->cancel_cheque}}">{{$docs_list->cancel_cheque}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="llp_agreement">LLP Agreement:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">

                        <input type="file" name="llp_agreement" id="file-9" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-9" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                                <span id="llp_agreement_file">
                                    @if(!empty($docs_list->llp_agreement))
                                    <span id="llp_agreement_file_exist">{{$docs_list->llp_agreement}}</span>
                                    @else
                                    <span id="llp_agreement_file_not_exist">Choose a file...</span>
                                    @endif
                            </span>
                        </label>
                        @if(!empty($docs_list->llp_agreement))
                        <button class="button124" data-name="llp_agreement" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button> 
                        @endif                             
                        <div id="llp_agreement_error"></div>
                        
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->llp_agreement))
                            <a href="/download/merchant-document/{{$docs_list->llp_agreement}}">{{$docs_list->llp_agreement}}</a>
                        @endif
                    </div>
                </div>
                <input type="hidden" name="id" id="id" value="{{!empty($docs_list->id)?$docs_list->id:''}}">
            </div>
        </div>
        @break
    @case(9)
        <div>
            <div class="text-center color-red">
                Note:Pdfs & Images are only allowed up to 5mb in size
            </div>
            <div id="ajax-activate-account-failed" class="text-center color-red"></div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="comp_pan_card">Company Pancard:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="comp_pan_card" id="file-1" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-1" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="comp_pan_card_file">
                                @if(!empty($docs_list->comp_pan_card))
                                <span id="comp_pan_card_file_exist">{{$docs_list->comp_pan_card}}</span>
                                @else
                                <span id="comp_pan_card_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                       </label>
                        @if(!empty($docs_list->comp_pan_card))
                        <button type="reset" class="button124" data-name="comp_pan_card" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button>
                        @endif
                        <div id="comp_pan_card_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->comp_pan_card))
                            <a href="/download/merchant-document/{{$docs_list->comp_pan_card}}" >{{$docs_list->comp_pan_card}}</a>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="mer_pan_card">Authorized Signatory Pancard:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="mer_pan_card" id="file-2" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-2" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="mer_pan_card_file">
                                @if(!empty($docs_list->mer_pan_card))
                                <span id="mer_pan_card_file_exist">{{$docs_list->mer_pan_card}}</span>
                                @else
                                <span id="mer_pan_card_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                       </label>
                       @if(!empty($docs_list->mer_pan_card))
                       <button type="reset" class="button124" data-name="mer_pan_card" data-id="{{$docs_list->id}}">
                           <i class="fa fa-times"></i>
                       </button>
                       @endif
                       <div id="mer_pan_card_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->mer_pan_card))
                        <a href="/download/merchant-document/{{$docs_list->mer_pan_card}}">{{$docs_list->mer_pan_card}}</a>
                        @endif   
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="mer_aadhar_card">Authorized Signatory Aadhar Card:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="mer_aadhar_card" id="file-3" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-3" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="mer_aadhar_card_file">
                                @if(!empty($docs_list->mer_aadhar_card))
                                <span id="mer_aadhar_card_file_exist">{{$docs_list->mer_aadhar_card}}</span>
                                @else
                                <span id="mer_aadhar_card_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                       </label>
                       @if(!empty($docs_list->mer_aadhar_card))
                       <button type="reset" class="button124" data-name="mer_aadhar_card" data-id="{{$docs_list->id}}">
                           <i class="fa fa-times"></i>
                       </button>
                       @endif
                       <div id="mer_aadhar_card_error"></div>
                    </div>
                    <div class="col-sm-4">
                        @if(!empty($docs_list->mer_aadhar_card))
                        <a href="/download/merchant-document/{{$docs_list->mer_aadhar_card}}">{{$docs_list->mer_aadhar_card}}</a>
                        @endif   
                    </div>
                </div>
                <input type="hidden" name="id" id="id" value="{{!empty($docs_list->id)?$docs_list->id:''}}">
            </div>
        </div>
        @break
    @default
        <div>
            <div class="text-center color-red">
                Note:Pdfs & Images are only allowed up to 5mb in size
            </div>
            <div id="ajax-activate-account-failed" class="text-center color-red"></div>
            <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="comp_pan_card">Company Pancard:<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="file" name="comp_pan_card" id="file-1" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                            <label for="file-1" class="custom-file-upload">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                </svg> 
                                <span id="comp_pan_card_file">
                                    @if(!empty($docs_list->comp_pan_card))
                                    <span id="comp_pan_card_file_exist">{{$docs_list->comp_pan_card}}</span>
                                    @else
                                    <span id="comp_pan_card_file_not_exist">Choose a file...</span>
                                    @endif
                                </span>
                        </label>
                            @if(!empty($docs_list->comp_pan_card))
                            <button type="reset" class="button124" data-name="comp_pan_card" data-id="{{$docs_list->id}}">
                                <i class="fa fa-times"></i>
                            </button>
                            @endif
                            <div id="comp_pan_card_error"></div>
                        </div>
                        <div class="col-sm-4">
                            @if(!empty($docs_list->comp_pan_card))
                                <a href="/download/merchant-document/{{$docs_list->comp_pan_card}}" >{{$docs_list->comp_pan_card}}</a>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="mer_pan_card">Authorized Signatory Pancard:<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="file" name="mer_pan_card" id="file-3" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                            <label for="file-3" class="custom-file-upload">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                </svg> 
                                <span id="mer_pan_card_file">
                                    @if(!empty($docs_list->mer_pan_card))
                                    <span id="mer_pan_card_file_exist">{{$docs_list->mer_pan_card}}</span>
                                    @else
                                    <span id="mer_pan_card_file_not_exist">Choose a file...</span>
                                    @endif
                                </span>
                        </label>
                        @if(!empty($docs_list->mer_pan_card))
                        <button type="reset" class="button124" data-name="mer_pan_card" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button>
                        @endif
                        <div id="mer_pan_card_error"></div>
                        </div>
                        <div class="col-sm-4">
                            @if(!empty($docs_list->mer_pan_card))
                            <a href="/download/merchant-document/{{$docs_list->mer_pan_card}}">{{$docs_list->mer_pan_card}}</a>
                            @endif   
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="mer_aadhar_card">Authorized Signatory Aadhar Card:<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="file" name="mer_aadhar_card" id="file-4" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                            <label for="file-4" class="custom-file-upload">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                </svg> 
                                <span id="mer_aadhar_card_file">
                                    @if(!empty($docs_list->mer_aadhar_card))
                                    <span id="mer_aadhar_card_file_exist">{{$docs_list->mer_aadhar_card}}</span>
                                    @else
                                    <span id="mer_aadhar_card_file_not_exist">Choose a file...</span>
                                    @endif
                                </span>
                        </label>
                        @if(!empty($docs_list->mer_aadhar_card))
                        <button type="reset" class="button124" data-name="mer_aadhar_card" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button>
                        @endif
                        <div id="mer_aadhar_card_error"></div>
                        </div>
                        <div class="col-sm-4">
                            @if(!empty($docs_list->mer_aadhar_card))
                            <a href="/download/merchant-document/{{$docs_list->mer_aadhar_card}}">{{$docs_list->mer_aadhar_card}}</a>
                            @endif   
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="registration_doc">Registration:<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="file" name="registration_doc" id="file-5" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                            <label for="file-5" class="custom-file-upload">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                </svg> 
                                <span id="registration_doc_file">
                                    @if(!empty($docs_list->registration_doc))
                                    <span id="registration_doc_file_exist">{{$docs_list->registration_doc}}</span>
                                    @else
                                    <span id="registration_doc_file_not_exist">Choose a file...</span>
                                    @endif
                                </span>
                        </label>
                        @if(!empty($docs_list->registration_doc))
                        <button type="reset" class="button124" data-name="registration_doc" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button>
                        @endif
                        <div id="registration_doc_error"></div>
                        </div>
                        <div class="col-sm-4">
                            @if(!empty($docs_list->registration_doc))
                            <a href="/download/merchant-document/{{$docs_list->registration_doc}}">{{$docs_list->registration_doc}}</a>
                            @endif   
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="trust_constitutional">Trust Deed/ Bye-laws/ Constitutional Document:<span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="file" name="trust_constitutional" id="file-6" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                            <label for="file-6" class="custom-file-upload">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                </svg> 
                                <span id="trust_constitutional_file">
                                    @if(!empty($docs_list->trust_constitutional))
                                    <span id="trust_constitutional_file_exist">{{$docs_list->trust_constitutional}}</span>
                                    @else
                                    <span id="trust_constitutional_file_not_exist">Choose a file...</span>
                                    @endif
                                </span>
                        </label>
                        @if(!empty($docs_list->trust_constitutional))
                        <button type="reset" class="button124" data-name="trust_constitutional" data-id="{{$docs_list->id}}">
                            <i class="fa fa-times"></i>
                        </button>
                        @endif
                        <div id="trust_constitutional_error"></div>
                        </div>
                        <div class="col-sm-4">
                            @if(!empty($docs_list->trust_constitutional))
                            <a href="/download/merchant-document/{{$docs_list->trust_constitutional}}">{{$docs_list->trust_constitutional}}</a>
                            @endif   
                        </div>
                    </div>
		            <div class="form-group">
                    <label class="control-label col-sm-4" for="no_objection_doc">No Objection Certificate:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="file" name="no_objection_doc" id="file-9" class="inputfile form-control inputfile-2" data-multiple-caption="{count} files selected" multiple />
                        <label for="file-9" class="custom-file-upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg> 
                            <span id="no_objection_doc_file">
                                @if(!empty($docs_list->no_objection_doc))
                                <span id="no_objection_doc_file_exist">{{$docs_list->no_objection_doc}}</span>
                                @else
                                <span id="no_objection_doc_file_not_exist">Choose a file...</span>
                                @endif
                            </span>
                       </label>
                       @if(!empty($docs_list->no_objection_doc))
                       <button type="reset" class="button124" data-name="no_objection_doc" data-id="{{$docs_list->id}}">
                           <i class="fa fa-times"></i>
                       </button>
                       @endif
                       <div id="no_objection_doc_error"></div>
                    </div> 
                    <div class="col-sm-4">
                        @if(!empty($docs_list->no_objection_doc))
                        <a href="/download/merchant-document/{{$docs_list->no_objection_doc}}">{{$docs_list->no_objection_doc}}</a>
                        @endif   
                    </div>
                </div>
                <input type="hidden" name="id" id="id" value="{{!empty($docs_list->id)?$docs_list->id:''}}">
            </div>
        </div>
    @endswitch
</div>    