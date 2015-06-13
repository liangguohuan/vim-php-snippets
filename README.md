# vim php snippets

Generate vim snippets for php via 'https://github.com/alvan/vim-php-manual.git'

The generating files can be found in folder named 'tools'

If you use 'noesnippet' plugin, you can do the config like it below:

~~~vim
" Enable snipMate compatibility feature.
let g:neosnippet#enable_snipmate_compatibility = 1

" Tell Neosnippet about the other snippets
let g:neosnippet#snippets_directory='~/.vim/bundle/vim-snippets/snippets,~/.vim/bundle/vim-php-snippets'
~~~

We can do something better, it is convenient to delete the arg's type tip and others
~~~vim
" Map to nice work in PHP
autocmd FileType php inoremap <buffer> ;; <End>;
autocmd FileType php nnoremap <buffer> ;; <End>A;<esc>
autocmd FileType php inoremap <buffer> $$ <C-Left>$<esc>ea
autocmd FileType php inoremap <buffer> $g <C-Left>$<esc>ea->
autocmd FileType php inoremap <buffer> -g <End>->
autocmd FileType php inoremap <buffer> <C-Space> <C-Left>$<esc>ea = 
autocmd FileType php smap <buffer> kk <Esc><C-Left><S-Left>viwdea
~~~

