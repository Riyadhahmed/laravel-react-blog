import React, {Component} from "react";
import ReactPaginate from "react-paginate";
import axios from 'axios'
import {Link} from 'react-router-dom'

export default class News extends Component {
    constructor() {
        super();
        this.state = {
            news: [],
            offset: 0,
            pageCount: 0,
            limit: 3,
            perPage: 3
        };
    }

    componentDidMount() {
        this.fetchBlogs();
    }

    fetchBlogs = () => {

        axios.get('/api/allBlogs', {
            params: {
                limit: this.state.limit, offset: this.state.offset
            }
        })
            .then(response => {
                this.setState({
                    news: response.data.result,
                    pageCount: Math.ceil(response.data.total / this.state.limit)
                });
            })
            .catch(error => {
                console.log(error);
            });
    }

    handlePageClick = data => {
        let selected = data.selected;
        let offset = Math.ceil(selected * this.state.perPage);

        this.setState({offset: offset}, () => {
            this.fetchBlogs();
        });
    };

    renderNews = () => {
        return this.state.news.map((post, index) => {
            const description = post.description.substring(0, 300);

            return (
                <div className="col-md-12" key={index}>
                    <div className="blog-item">
                        <img className="blog-thumb set-bg img-thumbnail" src={'../' + post.file_path}/>
                        <div className="blog-content">
                            <Link to={"blog/" + post.id}>
                                <h6>{post.title}</h6></Link>
                            <div className="blog-meta">
                                <span><i className="fa fa-calendar-o"></i> {post.created_at}</span>
                                <span><i
                                    className="fa fa-user"></i> {post.author}</span>
                            </div>
                            <p>{description} <Link to={"blog/" + post.id}
                                                   className="text-green">
                                read more</Link>
                            </p>
                        </div>
                    </div>
                </div>
            );
        });
    }

    render() {
        return (
            <div className="container m-top-60">
                <div className="row">
                    <h4>Laravel React Blogs</h4>
                    <hr/>
                    {this.renderNews()}
                    <ReactPaginate
                        previousLabel={"previous"}
                        nextLabel={"next"}
                        breakLabel={"..."}
                        breakClassName={"break-me"}
                        pageCount={this.state.pageCount}
                        marginPagesDisplayed={2}
                        pageRangeDisplayed={2}
                        onPageChange={this.handlePageClick}
                        containerClassName={"pagination"}
                        subContainerClassName={"page-item pages pagination"}
                        activeClassName={"active"}
                    />
                </div>
            </div>
        );
    }
}
