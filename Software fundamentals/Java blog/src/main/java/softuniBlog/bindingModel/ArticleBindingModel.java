package softuniBlog.bindingModel;

import javax.validation.constraints.NotNull;

public class ArticleBindingModel {
    @NotNull
    private String title;

    @NotNull
    private String content;

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public String getContent() {
        return content;
    }

    public void setContent(String content) {
        this.content = content;
    }

    private Integer categoryId;

    public Integer getCategoryId() {
        return categoryId;    }

    public void setCategoryId(Integer categoryId) {
        this.categoryId = categoryId;
    }

    private String tagString;

    public String getTagString() {
        return tagString;
    }

    public void setTagString(String tagStrings) {
        this.tagString = tagStrings;
    }
}
