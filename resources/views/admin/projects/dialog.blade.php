<div class="modal fade" id="project">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><i class="fa fa-cogs"></i> <span>{{ Lang::get('projects.create') }}</span></h4>
            </div>
            <form role="form">
                <input type="hidden" id="project_id" name="id" />
                <div class="modal-body">

                    <div class="callout callout-danger">
                        <i class="icon fa fa-warning"></i> {{ Lang::get('projects.warning') }}
                    </div>

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#project_details" data-toggle="tab">{{ Lang::get('projects.project_details') }}</a></li>
                            <li><a href="#project_repo" data-toggle="tab">{{ Lang::get('projects.repository') }}</a></li>
                            <li><a href="#project_build" data-toggle="tab">{{ Lang::get('projects.build_options') }}</a></li>
                            <li><a href="#project_key" data-toggle="tab">{{ Lang::get('projects.ssh_key') }}</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="project_details">
                                <div class="form-group">
                                    <label for="project_name">{{ Lang::get('projects.name') }}</label>
                                    <input type="text" class="form-control" name="name" id="project_name" placeholder="{{ Lang::get('projects.awesome') }}" />
                                </div>
                                <div class="form-group">
                                    <label for="project_group_id">{{ Lang::get('projects.group') }}</label>
                                    <select id="project_group_id" name="group_id" class="form-control">
                                        @foreach($groups as $group)
                                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if (count($templates) > 0)
                                <div class="form-group" id="template-list">
                                    <label for="project_template_id">{{ Lang::get('templates.type') }}</label>
                                    <select id="project_template_id" name="template_id" class="form-control">
                                        <option value="">{{ Lang::get('templates.custom') }}</option>
                                        @foreach ($templates as $template)
                                            <option value="{{ $template->id }}">{{ $template->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label for="project_url">{{ Lang::get('projects.url') }}</label>
                                    <input type="text" class="form-control" name="url" id="project_url" placeholder="http://www.example.com" />
                                </div>
                            </div>

                            <div class="tab-pane" id="project_build">

                                <div class="form-group">
                                    <label for="project_builds_to_keep">{{ Lang::get('projects.builds') }}</label>
                                    <input type="number" class="form-control" name="builds_to_keep" min="1" max="20" id="project_builds_to_keep" placeholder="10" />
                                </div>
                                <div class="form-group">
                                    <label for="project_build_url">{{ Lang::get('projects.image') }}</label>
                                    <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="right" title="{{ Lang::get('projects.ci_image') }}"></i>
                                    <input type="text" class="form-control" name="build_url" id="project_build_url" placeholder="http://ci.example.com/status.png?project=1" />
                                </div>
                                <div class="form-group">
                                    <label>{{ Lang::get('projects.options') }}</label>
                                    <div class="checkbox">
                                        <label for="project_include_dev">
                                            <input type="checkbox" value="1" name="include_dev" id="project_include_dev" />
                                            {{ Lang::get('projects.include_dev') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="project_repo">
                                <div class="form-group">
                                    <label for="project_repository">{{ Lang::get('projects.repository_url') }}</label>
                                    <input type="text" class="form-control" name="repository" id="project_repository" placeholder="git&#64;git.example.com:repositories/project.git" />
                                </div>
                                <div class="form-group">
                                    <label for="project_branch">{{ Lang::get('projects.branch') }}</label>
                                    <input type="text" class="form-control" name="branch" id="project_branch"  placeholder="master" />
                                </div>
                                <div class="form-group">
                                    <label>{{ Lang::get('projects.options') }}</label>
                                    <div class="checkbox">
                                        <label for="project_allow_other_branch">
                                            <input type="checkbox" value="1" name="allow_other_branch" id="project_allow_other_branch" />
                                            {{ Lang::get('projects.change_branch') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="project_key">
                                <div class="form-group">

                                    <div class="radio">
                                        <label for="project_ssh_generate">
                                            <input class="sshkey" id="project_ssh_generate" name="sshkey" value="generate" type="radio" /> <strong>{{ Lang::get('projects.generate_ssh_key') }}</strong>
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <label for="project_key_existing">
                                            <input class="sshkey" name="sshkey" id="project_key_existing" value="existing" type="radio" /> <strong>{{ Lang::get('projects.use_ssh_key') }}</strong>

                                            <div class="sshkey-container">
                                                <select id="project_key_id" name="key_id" class="form-control">
                                                    @foreach($keys as $key)
                                                        <option value="{{ $key->id }}">{{ $key->name }} ({{ $key->fingerprint }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <label for="private_key_supply">
                                            <input class="sshkey" name="sshkey" id="private_key_supply" value="supply" type="radio" /> <strong>{{ Lang::get('projects.private_ssh_key') }}</strong>

                                            <div class="sshkey-container">
                                                @if (!$is_secure)
                                                <div class="callout callout-warning">
                                                    <i class="icon fa fa-warning"></i> <strong>{{ Lang::get('app.warning') }}</strong>
                                                    {{ Lang::get('projects.insecure') }}
                                                </div>
                                                @endif

                                                <textarea name="private_key" rows="10" id="project_private_key" class="form-control" placeholder="{{ Lang::get('projects.ssh_key_info') }}"></textarea>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left btn-delete"><i class="fa fa-trash"></i> {{ Lang::get('app.delete') }}</button>
                    <button type="button" class="btn btn-primary pull-right btn-save"><i class="fa fa-save"></i> {{ Lang::get('app.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
