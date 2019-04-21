import React, {Component} from "react";
import axios from 'axios'
import  BlockListLeft from '../blocks/Block_List_Left'
import  BlockGrid from '../blocks/Block_Grid'

export default class BlogWidget extends Component {
    constructor() {
        super();
        this.state = {
            posts: []
        };
    }

    componentDidMount() {
        this.fetchPosts();
    }

    
    fetchPosts = () => {

        axios.get('/api/blogWidget', {
            params: {
                category: this.props.category, limit: this.props.limit
            }
        })
            .then(response => {
                this.setState({
                    posts: response.data.result
                });
            })
            .catch(error => {
                console.log(error);
            });
    }


    renderPosts = () => {
        return this.state.posts.map((data, index) => {
            if (this.props.layout === "list") {
                return <BlockListLeft key={data.id} post={data}/>
            } else {
                return <BlockGrid key={data.id} post={data}/>
            }

        });
    }

    render() {
        return (
            <div>
                {this.renderPosts()}
            </div>
        );
    }
}
